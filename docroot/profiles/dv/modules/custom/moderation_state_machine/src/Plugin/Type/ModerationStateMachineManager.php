<?php

/**
 * @file
 * Contains \Drupal\activity_creator\Plugin\ActivityActionManager.
 */

namespace Drupal\moderation_state_machine\Plugin\Type;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Component\Utility\Html;

/**
 * Provides the Activity Moderation plugin manager.
 */
class ModerationStateMachineManager extends DefaultPluginManager {

  /**
   * Constructor for Moderation State Machine objects.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/ModerationStateMachine', $namespaces, $module_handler, 'Drupal\moderation_state_machine\ModerationStateMachineInterface', 'Drupal\moderation_state_machine\Annotation\ModerationStateMachine');

    $this->alterInfo('moderation_state_machine_info');
    $this->setCacheBackend($cache_backend, 'moderation_state_machine_plugins');
  }

  /**
   * Retrieves an options list of available trackers.
   *
   * @return string[]
   *   An associative array mapping the IDs of all available tracker plugins to
   *   their labels.
   */
  public function getOptionsList() {
    $options = array();
    foreach ($this->getDefinitions() as $plugin_id => $plugin_definition) {
      $options[$plugin_id] = Html::escape($plugin_definition['label']);
    }
    return $options;
  }

  /**
   * Get Plugin Id By Entity.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   * @return array
   */
  public function getPluginIdByEntity(ContentEntityInterface $entity) {
    $plugin_ids = [];

    foreach ($this->getDefinitions() as $plugin_id => $plugin_definition) {
      // skip default plugin
      if($plugin_id == 'moderation_state_machine_default') {
        continue;
      }

      if($plugin_definition['entity_type'] == $entity->getEntityTypeId() && $plugin_definition['entity_bundle'] == $entity->bundle()) {
        // if weight is not set we set it to 0
        $plugin_definition['weight'] = isset($plugin_definition['weight']) ? $plugin_definition['weight'] : 0;
        $plugin_ids[$plugin_definition['weight']] = $plugin_id;
      }
    }

    if(!empty($plugin_ids)) {
      // sort plugin_ids by weight
      asort($plugin_ids, SORT_NUMERIC);
      return $plugin_ids;
    }

    // if no other plugins are implemented return default
    return ['moderation_state_machine_default'];
  }

}

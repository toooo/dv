# Workflow

## Development
- relations: Code repository
- meta:
  - roles:
    - Developer
    - DevOps
  - tools:
    - Drupal
- doc: http://some-path/doc.md#drupal

### Test h3
I ondak nastavis tu pisati sta te volja!
Bla bla bla ... Trrrttt

## Code repository
- relations: Documentation, test|Continuous integration
- meta:
  - roles:
    - Developer
    - DevOps
  - tools:
    - Drupal
- doc: [test](../03_Architecture/answer_comment.md)

## Documentation
- meta:
  - roles:
    - Developer
    - DevOps
  - tools:
    - [daux.io](https://github.com/dauxio/daux.io)
    
    

- Documentation in docroot/profiles/dv/docs contains:
  - daux theme
  - docs folder where the actual markup files reside
  - global.json for daux configuration
- Access documentation locally by `$daux serve` in docroot/profiles/dv/docs 


## Continuous integration
- relations: Notifications
- meta:
  - roles:
    - Developer
    - DevOps
- doc: http://some-path/doc.md

## Notifications
- relations: Test passed?
- meta:
  - roles:
    - Developer
    - DevOps
  - tools:
    - Drupal
- doc: http://some-path/doc3.md#slack

## Test passed?
- type: decision
- relations: Yes|Artifact, No|Development

## Artifact
- meta: 
  - roles:
    - DevOps
- tool: "Travis"
- doc: http://some-path/doc.md#artifact;




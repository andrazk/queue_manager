# Queue Manager
Simple queue manager with PHP and Docker

## Requirements

- Docker
- Vagrant [Windows only]

## Usage

```
git clone https://github.com/andrazk/queue_manager.git
cd queue_manager
./install
./run

./stop [optional for removing all containers]
```

Run command will start queue container and four worker containers, one of each type. Client container generates 100 random tasks. Log with results is displayed to user.

## Tests

```
./test
```


Author: Andraž Krašček

E-mail: andraz.krascek@gmail.com

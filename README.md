


## Local dev

### Usage

### Launch machine
Run in terminal

```
cd %userprofile%\Homestead
vagrant up
```

After machine launch connect with SSH
and go to project catalog.

### Close machine

```
vagrant halt
```

### Connect to machine
```
vagrant ssh
```

```
cd ~/code/refcard-backend
```

### Install components

```
cd ~/code/refcard-backend
composer install
```

### Reload machine

I.e. after changes to `Homestead.yaml`

```
vagrant reload --provision
```


### Open website

```
http://192.168.10.10/api/example
```

### Prerequisites

`Homestead Virtual Machine` with full PHP environment.

* Virtual Box
* Vagrant
  https://www.vagrantup.com/
* Homestead VM
  https://laravel.com/docs/8.x/homestead

Install Homestead in `%userprofile%\Homestead`

### Configuration

Set folders and sites in: `%userprofile%\Homestead\Homestead.yaml`

```
---
ip: "192.168.10.10"
memory: 2048
cpus: 2
provider: virtualbox

authorize: ~/.ssh/id_rsa.pub

keys:
    - ~/.ssh/id_rsa

folders:
    - map: ~/Documents\GitHub\refcard-backend
      to: /home/vagrant/code/refcard-backend

sites:
    - map: refcard-backend.test
      to: /home/vagrant/code/refcard-backend/public

databases:
    - homestead

features:
    - mariadb: false
    - ohmyzsh: false
    - webdriver: false

# ports:
#     - send: 50000
#       to: 5000
#     - send: 7777
#       to: 777
#       protocol: udp

```





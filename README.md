#### Requirements
* Apache 2.2+
* PHP 5.3+
* MySQL 5.1+

## Installation via GIT
Create local repository and add UX-CMS as remote repository:
```sh
git init && git remote add framework https://github.com/Ator9/UX-CMS.git && git pull framework master
```
## Push online from local repository (SSH)
Create online repository and setup hook:
```sh
git init --bare && cd hooks && touch post-receive && chmod +x post-receive && nano post-receive
```
```sh
#!/bin/sh
git --work-tree=/var/project/www --git-dir=/var/project/barerepo checkout -f
```
##### Option A - Simple SSH and Push
```sh
git remote add online gituser@server.com:/repos/site.git
git push online master
```
##### Option B - SSH Key and Push
Client Setup. Create "gitkey" ssh key and set "config" file at ~/.ssh:
```sh
ssh-keygen
nano config
```
```sh
Host serverCom
  HostName server.com
  User gituser
  IdentityFile ~/.ssh/gitkey
```
```sh
git remote add online serverCom:/repos/site.git
git push online master
```
Server Setup. Create git user and set client public ssh key ("gitkey.pub"):
```sh
sudo adduser gituser
```
```sh
mkdir /home/gituser/.ssh
echo "client_public_ssh_key" >> /home/gituser/.ssh/authorized_keys
```

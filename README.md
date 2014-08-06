#### Requirements
* Apache 2.2+
* PHP 5.3+
* MySQL 5.1+

## Installation via GIT
Create local repository and add UX-CMS as remote repository:
```sh
mkdir myProject && cd myProject

git init && git remote add framework https://github.com/Ator9/UX-CMS.git && git pull framework master
```
## Push online from local repository (SSH)
Create online repository and setup hook:
```sh
mkdir site.git && cd site.git

git init --bare && cd hooks && touch post-receive && chmod +x post-receive && nano post-receive
```
```sh
#!/bin/sh
git --work-tree=/var/www/domain.com --git-dir=/home/repos/site.git checkout -f
```
##### Option A - Simple SSH and Push
```sh
git remote add online user@server:/home/repos/site.git
git push online master
```
##### Option B - SSH Key and Push
Client Setup. Create "gitkey" ssh key and set "config" file at /home/user./ssh:
```sh
ssh-keygen
nano config
```
```sh
Host repohostCom
  HostName repohost.com
  User gituser
  IdentityFile /home/user/.ssh/gitkey
```
```sh
git remote add online repohostCom:/home/repos/site.git
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

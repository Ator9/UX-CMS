#### Requirements
* Apache 2.2+
* PHP 5.3+
* MySQL 5.1+

## Installation via GIT
Create local repository and add UX-CMS as remote repository:
```sh
mkdir myProject; cd myProject
git init
git remote add framework https://github.com/Ator9/UX-CMS.git
git pull framework master
```
## Push online from local repository (SSH):
Create online repository and setup hook
```sh
mkdir site.git; cd site.git
git init --bare

cd hooks; touch post-receive; chmod +x post-receive; vi post-receive
```
```sh
#!/bin/sh
git --work-tree=/var/www/domain.com --git-dir=/home/repo/site.git checkout -f
```
Push from local
```sh
git remote add online ssh://user@server:/home/repo/site.git
git push online master
```

#### Requirements
* Apache 2.2+
* PHP 5.3+
* MySQL 5.1+

## Installation via GIT
Create local repository and add UX-CMS as remote repository:
```sh
mkdir myProject; cd myProject/

git init
git remote add framework https://github.com/Ator9/UX-CMS.git
git pull framework master
```

## Push to Server via SSH
Create online repository:
```sh
mkdir myProject; cd myProject/
git init
git config receive.denyCurrentBranch ignore
```
Push from local:
```sh
git remote add online ssh://user@server:/home/repository
git push online master
```

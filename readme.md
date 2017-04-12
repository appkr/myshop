## My Shop

라라벨 학습용 쇼핑몰 프로젝트입니다.

> 아래 콘솔 명령 블록은 모두 경로를 가지고 있습니다. `~/myshop`으로 시작하는 명령은 모두 프로젝트 폴더에서 실행해야 하며, `~/any`로 시작하는 명령은 아무곳에서나 실행해도 무방합니다.

## 1. 프로젝트 복제

프로젝트를 복제합니다.

```bash
~ $ git clone git@github.com:appkr/myshop.git

# 깃허브에 SSH 키를 등록하지 않았다면...
~ $ git clone https://github.com/appkr/myshop.git
```

이 프로젝트가 의존하는 라이브러리를 설치하고, 프로젝트 설정 파일을 생성합니다.

```bash
# composer가 없다면 getcomposer.org를 참고해주세요.

~ $ cd myshop
~/myshop $ composer install
~/myshop $ cp .env.example .env
~/myshop $ php artisan key:generate
```

## 2. 로컬 개발 환경

상용과 같은 환경을 유지하기 위해 도커(Docker)를 이용한 개발 환경을 가정하고 있습니다. 상용 환경에서는 RDS 또는 별도 인스턴스에서 작동하는 데이터베이스를 연결하는 반면, 한 개의 도커 컨테이너에 MySQL, Redis 등을 포함하고 있습니다.

### 2.1. 도커 엔진 설치

아래 링크를 방문해서 각자의 운영체제에 맞는 Docker 패키지를 설치합니다.

> https://www.docker.com/products/docker

잘 설치되었나 확인합니다.

```bash
~/any $ docker --version
# Docker version 1.13.0, build 49bf474
```

#### 3.1.1. OS X

OS X에서는 2.1의 링크를 방문하지 않고도 Homebrew를 이용해서 더 편리하게 도커를 설치할 수 있습니다.

```bash
~/any $ brew cask install docker --appdir=/Applications
```

#### 2.1.2. Ubuntu Linux

[별도 문서](docs/DOCKER-UBUNTU-HOT-TO.md)에서 설명합니다.

#### 2.1.3. Windows

[별도 문서](docs/DOCKER-WINDOWS-HOT-TO.md)에서 설명합니다.

### 2.2. 도커 컨테이너 실행

다음 명령을 실행합니다. 전체 명령을 보고 싶다면 `start.sh` 파일을 열어서 확인합니다. 

```bash
~/myshop $ bash start.sh
# myshop-local

~/any $ docker ps
CONTAINER ID    IMAGE                 COMMAND                  CREATED           STATUS           PORTS                  NAMES
b8d32d2783e1    myshop:local         "docker-php-entryp..."   16 seconds ago    Up 15 seconds    0.0.0.0:8000->80/tcp...   myshop
```

**최초 실행할 때는 MySQL 데이터베이스를 만들고, `homestead` 사용자를 등록해야 합니다.**

```bash
~/myshop $ bash init.sh
# ...
```

브라우저에서 `http://localhost:8000`을 열어 작동을 확인합니다. MySQL 클라이언트에서 `127.0.0.1:3306`으로 접속해 봅니다.

### 2.3. 워크플로우

한 번 실행했던 컨테이너는 삭제하지 않았다면, `start.sh`, `stop.sh` 명령을 이용해서 컨테이너를 실행하거나 중지할 수 있습니다.

```bash
~/any $ bash stop.sh
# myshop-local

~/any $ bash start.sh
# myshop-local
```

컨테이너를 완전히 삭제하고 싶다면 아래 명령을 수행합니다. 컨테이너를 삭제해도 이미지는 그대로 남아 있으므로, 언제든 컨테이너를 다시 띄울 수 있습니다. 

컨테이너를 삭제해 기존에 사용했던 MySQL 데이터는 `docker-mount-points` 폴더에 여전히 남아 있습니다. 데이터까지도 삭제하고 싶다면 해당 폴더의 내용을 전부 지웁니다.

```bash
~/any $ docker stop myshop-local && docker rm myshop-local
# myshop-local
```

이미지를 완전히 삭제하려면 다음 명령을 이용합니다.

```bash
~/any $ docker rmi myshop:local
# myshop:local
```

### 2.4. 서비스별 접속 정보

Service|Connection Info
---|---
Web|`http://localhost:8000`
Supervisor|`http://localhost:9001` (HTTP Basic Auth => `homestead`/`secret`)
MySQL|`$ mysql -h127.0.0.1 -P3306 -uroot -psecret`
Redis|`$ redis-cli -h 127.0.0.1 -p 6379`
Xdebug|key: `IDEA`, port: `9999`

### 2.5. 유틸리티 함수

미리 만들어 둔 유틸리티 함수를 쉘에 설치하면, `docker exec -it myshop-local bash` 대신 `dbash myshop-local` 처럼 짧은 명령을 이용할 수 있습니다. 사용할 수 있는 명령은 `.dockerunility` 파일을 열어 확인해 주세요.

> bash를 쓰시는 분들은 `.zshrc` 대신 `.bashrc`에 아래 내용을 추가해야 합니다. 

```bash
~/myshop $ cp .dockerunility ~/ \
    && echo "" >> .zshrc \
    && echo "source .dockerunility" >> .zshrc
```

## 3. 상용 배포

### 3.1. ECS를 이용한 도커 이미지 배포

AWS ECS(Elastic Container Service) 배포 환경을 포함하고 있습니다. ECS 배포에 대한 자세한 내용은 [블로그 포스트](http://blog.appkr.kr/work-n-play/deploy-with-ecs/)를 참고해주세요.

### 3.2. 이미지 복사를 통한 이미지 배포

로컬 컴퓨터에서 이미 빌드한 이미지를 `tar` 파일로 저장합니다.

```bash
~/myshop $ docker build --tag myshop:production .
~/any $ docker save myshop:production > myshop-production.tar
```

배포할 컴퓨터에서 `tar` 이미지를 임포트합니다. 상용 이미지는 `80` 포트만 노출하고 있으므로 다음과 같이 실행해야 합니다.

```bash
~/any $ docker load < myshop-production.tar
~/any $ docker run --detach \
    --name myshop-production \
    --publish 80:80 \
    myshop:production
```

### 3.3. 다른 방법으로 배포

`Dockerfile`, `docker-files` 등등 도커 관련 파일을 지우고(안 지워도 무방합니다) 다른 배포 환경으로 셋팅할 수 있습니다(e.g. Elastic Beanstalk, DigitalOcean, Heroku, ...).

## 4. Docker Basic

다음 블로그 포스트를 참고하세요.

https://subicura.com/2017/01/19/docker-guide-for-beginners-1.html

## 5. 문제 해결

호스트 컴퓨터에서 8000, 3306, 6379 포트를 이미 사용하고 있다면 다른 포트로 바인딩합니다. 혹, 포트 충돌이 발생하면 작동 중인 컨테이너를 삭제하고 다시 실행합니다.

```bash
~/any $ docker stop myshop-local && docker rm myshop-local
# myshop-local
```

대부분의 문제는 MySQL에서 발생합니다. 이럴 때는 처음부터 다시 하는 것이 가장 빠르고 쉽습니다. 아래는 초기화 방법입니다. 초기화 후 2.2. 의 과정을 다시 수행합니다.

```bash
# 컨테이너를 중지시키고 삭제합니다.
~/any $ docker stop myshop-local && docker rm myshop-local

# 이미지를 삭제합니다.
~/any $ docker rmi --force myshop:local

# MySQL 데이터베이스를 삭제합니다.
~/myshop $ rm -rf docker-mount-point/*
```

## 6. Sponsor

[Jetbrains](https://www.jetbrains.com/) 사에서 IntelliJ IDE를 제공해주셨습니다.

![](intellij_logo.png)

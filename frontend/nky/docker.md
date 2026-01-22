**Config (First Install Docker)**
-

**1. Create Network**
- Linux
```
docker network create -o "com.docker.network.bridge.enable_ip_masquerade"="true" -o "com.docker.network.bridge.enable_icc"="true" -o "com.docker.network.bridge.host_binding_ipv4"="0.0.0.0" -o "com.docker.network.driver.mtu"="1500" --subnet=100.1.0.0/16 --gateway=100.1.10.1 --driver=bridge wlan10p
```

- Windows
```
docker network create -d bridge --opt com.docker.network.bridge.enable_ip_masquerade=true --opt com.docker.network.bridge.enable_icc=true --opt com.docker.network.bridge.host_binding_ipv4=0.0.0.0 --opt com.docker.network.driver.mtu=1500 --subnet=100.1.0.0/16 --gateway=100.1.10.1 wlan10p
```

**2. Install Dashboard**
```
docker run -d -p 8000:8000 -p 9001:9001 -p 9443:9443 --name=portainer --restart=always -v /var/run/docker.sock:/var/run/docker.sock -v portainer_data:/data portainer/portainer-ce:latest
```

**3. Install Docker Compose V.2** (refer : [here](https://docs.docker.com/compose/cli-command/))
```
mkdir -p ~/.docker/cli-plugins/
```
```
curl -SL https://github.com/docker/compose/releases/download/v2.5.0/docker-compose-linux-x86_64 -o ~/.docker/cli-plugins/docker-compose
```
```
chmod +x ~/.docker/cli-plugins/docker-compose
```

Vagrant.configure(2)  do |config|
  config.vm.box = "ubuntu/trusty64"
  config.vm.hostname = "graylog"

  config.vm.network :forwarded_port, guest: 80, host: 8080
  config.vm.network :forwarded_port, guest: 5044, host: 5044
  config.vm.network :forwarded_port, guest: 9000, host: 9000
  config.vm.network :forwarded_port, guest: 12900, host: 12900
  config.vm.network :forwarded_port, guest: 12201, host: 12201, protocol: 'udp'
  config.vm.network :forwarded_port, guest: 12201, host: 12201, protocol: 'tcp'
  config.vm.network :forwarded_port, guest: 12202, host: 12202, protocol: 'udp'
  config.vm.network :forwarded_port, guest: 12202, host: 12202, protocol: 'tcp'

  config.vm.provider "virtualbox" do |v|
    v.memory = 2048
  end

  $script = <<SCRIPT
    apt-get update
    echo 'Going to download Graylog...'
    curl -S -s -L -O https://packages.graylog2.org/releases/graylog-omnibus/ubuntu/graylog_latest.deb
    dpkg -i graylog_latest.deb
    rm graylog_latest.deb
    wget -O /opt/graylog/plugin/graylog-plugin-beats-1.1.0-beta.3.jar https://github.com/Graylog2/graylog-plugin-beats/releases/download/1.1.0-beta.3/graylog-plugin-beats-1.1.0-beta.3.jar
    graylog-ctl set-external-ip http://127.0.0.1:8080/api
    graylog-ctl reconfigure
SCRIPT

  config.vm.provision "shell", inline: $script
end

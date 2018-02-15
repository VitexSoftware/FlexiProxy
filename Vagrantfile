Vagrant.configure("2") do |config|
  config.vm.box = "debian/stretch64"
  config.vm.provision :shell, path: "bootstrap.sh"
#  config.vm.network :forwarded_port, guest: 80, host: 8080
  config.vm.network "public_network"
  config.vm.synced_folder ".", "/vagrant"
  config.vm.provision "shell",
    run: "always",
    inline: "ifconfig eth1 192.168.0.17 netmask 255.255.255.0 up"
end

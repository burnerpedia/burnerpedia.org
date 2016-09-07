# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
    config.ssh.forward_agent = true

    config.vm.hostname = "burnerpedia
    config.vm.box = "puppetlabs/ubuntu-16.04-64-nocm"

    config.vm.provider :virtualbox do |vm|
        vm.customize ["modifyvm", :id, "--cpuexecutioncap", 25]
        vm.memory = 2048
        vm.cpus = 1
    end

    config.vm.provider :vmware_fusion do |vm, override|
        vm.vmx["memsize"] = 2048
        vm.vmx["numvcpus"] = 1
    end

    config.vm.network :private_network,
        ip: "10.10.10.10"
    config.vm.network :public_network,
        type: "dhcp",
        bridge: "eth0"

end

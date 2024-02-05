<?php
function create_vm($vm_name, $storage_size, $memory_allocation, $cpu_amount, $img_path, $rdp_port) {
    // Define the commands
    $commands = [
        '"C:\Program Files\Oracle\VirtualBox\VBoxManage.exe" createvm --name ' . $vm_name . ' --register',
        '"C:\Program Files\Oracle\VirtualBox\VBoxManage.exe" modifyvm ' . $vm_name . ' --memory ' . $memory_allocation . ' --cpus ' . $cpu_amount,
        '"C:\Program Files\Oracle\VirtualBox\VBoxManage.exe" createhd --filename "C:\path\to\your\directory\\' . $vm_name . '.vdi" --size ' . $storage_size . ' --format VDI',
        '"C:\Program Files\Oracle\VirtualBox\VBoxManage.exe" storagectl ' . $vm_name . ' --name "SATA Controller" --add sata',
        '"C:\Program Files\Oracle\VirtualBox\VBoxManage.exe" storageattach ' . $vm_name . ' --storagectl "SATA Controller" --port 0 --device 0 --type hdd --medium "C:\path\to\your\directory\\' . $vm_name . '.vdi"',
        '"C:\Program Files\Oracle\VirtualBox\VBoxManage.exe" storagectl ' . $vm_name . ' --name "IDE Controller" --add ide',
        '"C:\Program Files\Oracle\VirtualBox\VBoxManage.exe" storageattach ' . $vm_name . ' --storagectl "IDE Controller" --port 0 --device 0 --type dvddrive --medium ' . $img_path,
        '"C:\Program Files\Oracle\VirtualBox\VBoxManage.exe" modifyvm ' . $vm_name . ' --vrde on',
        '"C:\Program Files\Oracle\VirtualBox\VBoxManage.exe" modifyvm ' . $vm_name . ' --vrdeport ' . $rdp_port,
        '"C:\Program Files\Oracle\VirtualBox\VBoxManage.exe" startvm ' . $vm_name
    ];

    foreach ($commands as $command) {
        exec($command, $output, $return_var);

        // Success ?
        if ($return_var != 0) {
            echo "An error occurred while running the command: " . $command . "\n";
            echo "Error output: " . implode("\n", $output) . "\n";
            return;
        }
    }

    echo "VM " . $vm_name . " created, attached, and started successfully on RDP port " . $rdp_port . ".\n";
}
  
?>
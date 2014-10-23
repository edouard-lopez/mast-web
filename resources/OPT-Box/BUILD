#!/bin/sh
# Construct OS on SD-Card for OPT-Box
# By alban.lopez@gmail.com
# Version : 0.2

CURRENT_DIR="$( cd "$( dirname "$0" )" && pwd )"
echo $CURRENT_DIR

sudo dcfldd if=$CURRENT_DIR/Images_SD.Igor/Cubox-i_Debian_2.0_wheezy.raw of=/dev/mmcblk0 bs=4k conv=notrunc,noerror

sudo umount /dev/mmcblk0p1
sudo mkdir -p /media/cubox-i
sudo mount /dev/mmcblk0p1 /media/cubox-i

sudo cp -f $CURRENT_DIR/firstrun /media/cubox-i/etc/init.d
sudo cp -f $CURRENT_DIR/dhclient.conf /media/cubox-i/etc/dhcp
sudo cp -f $CURRENT_DIR/opt-registration /media/cubox-i/etc/network/if-up.d

#sudo dcfldd if=/dev/mmcblk0 bs=4k count=256000 conv=notrunc,noerror | gzip -c > "$CURRENT_DIR/OPT-Box_V0.4(ARM-Debian7.6)_KB575.gzip"

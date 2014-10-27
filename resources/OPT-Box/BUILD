#!/bin/sh
# Construct OS on SD-Card for OPT-Box
# By alban.lopez@gmail.com
# Version : 0.32
clear

MSG_FAIL="[ $(tput setaf 1)FAIL$(tput sgr 0) ]\t"
MSG_OK="[  $(tput setaf 2)OK$(tput sgr 0)  ]\t"
MSG_SKIP="[ $(tput setaf 3)SKIP$(tput sgr 0) ]\t"

success=0

CURRENT_DIR="$( cd "$( dirname "$0" )" && pwd )"

sudo umount /dev/mmcblk0* /media/cubox-i > /dev/null 2>&1
# sudo killall nautilus

case $1 in
	-f|f|-full|full)
		# sudo mkfs.ext4 -F /dev/mmcblk0
		echo "$(tput setaf 2)\n=== Deployment de OPT-OS (4min) ===$(tput sgr 0)"
		if dcfldd --version > /dev/null 2>&1; then
			sudo dcfldd if=$CURRENT_DIR/Images_SD.Igor/Cubox-i_Debian_2.0_wheezy.raw of=/dev/mmcblk0 bs=4k conv=notrunc,noerror
		else
			sudo dd if=$CURRENT_DIR/Images_SD.Igor/Cubox-i_Debian_2.0_wheezy.raw of=/dev/mmcblk0 bs=4k conv=notrunc,noerror
		fi
		if [ $? -eq 1 ]; then
			echo "$MSG_FAIL Write OPT-OS on media"
		else
			echo "$MSG_OK Write OPT-OS on media"
		fi
	;;
esac

sudo umount /dev/mmcblk0* /media/cubox-i > /dev/null 2>&1
sudo mkdir -p /media/cubox-i > /dev/null 2>&1
sudo mount /dev/mmcblk0p1 /media/cubox-i > /dev/null 2>&1


sudo cp -f $CURRENT_DIR/firstrun /media/cubox-i/etc/init.d > /dev/null 2>&1
sudo chmod +x /media/cubox-i/etc/init.d/firstrun > /dev/null 2>&1
if [ -x  "/media/cubox-i/etc/init.d/firstrun" ]
then
	echo "$MSG_OK /media/cubox-i/etc/init.d/firstrun - " $(grep Version /media/cubox-i/etc/init.d/firstrun )
	success=$((success+1))
else
	echo "$MSG_FAIL /media/cubox-i/etc/init.d/firstrun"
fi

sudo cp -f $CURRENT_DIR/dhclient.conf /media/cubox-i/etc/dhcp > /dev/null 2>&1
sudo chmod +x /media/cubox-i/etc/dhcp/dhclient.conf > /dev/null 2>&1
if [ -x  "/media/cubox-i/etc/dhcp/dhclient.conf" ]
then
	echo "$MSG_OK /media/cubox-i/etc/dhcp/dhclient.conf - " $(grep Version /media/cubox-i/etc/dhcp/dhclient.conf )
	success=$((success+1))
else
	echo "$MSG_FAIL /media/cubox-i/etc/dhcp/dhclient.conf"
fi

sudo cp -f $CURRENT_DIR/opt-registration /media/cubox-i/etc/network/if-up.d > /dev/null 2>&1
sudo chmod +x /media/cubox-i/etc/network/if-up.d/opt-registration > /dev/null 2>&1
if [ -x  "/media/cubox-i/etc/network/if-up.d/opt-registration" ]
then
	echo "$MSG_OK /media/cubox-i/etc/network/if-up.d/opt-registration - " $(grep Version /media/cubox-i/etc/network/if-up.d/opt-registration )
	success=$((success+1))
else
	echo "$MSG_FAIL /media/cubox-i/etc/network/if-up.d/opt-registration"
fi


if [ $success -eq 3 ]
then
	echo "$MSG_OK $(tput setaf 2)## Success : SD-Card is available. ##\n\n$(tput sgr 0)"
else
	echo "$MSG_FAIL $(tput setab 1)   Sortir et remettre la carte SD, puis relancer   ./BUILD   $(tput sgr 0)\n\n"
	exit 1
fi



#sudo dcfldd if=/dev/mmcblk0 bs=4k count=256000 conv=notrunc,noerror | gzip -c > "$CURRENT_DIR/OPT-Box_V0.4(ARM-Debian7.6)_KB575.gzip"

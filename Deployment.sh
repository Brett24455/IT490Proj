#!/usr/bin/bash
echo "Enter 'QA' to push changes from Development to QA."
echo "Enter 'PROD' to push changes from Development to Production."
read VAR
HOME="/home/brett"

if [[ $VAR = "QA" ]]
then
	rsync -av $HOME/git/IT490Proj/Environments/dev/dmzListener.php ~/git/IT490Proj/
	rsync -av $HOME/git/IT490Proj/Environments/dev/dbListener.php ~/git/IT490Proj/
	rsync -av --exclude='dbWebsiteRabbitMQ.ini' --exclude='dmzWebsiteRabbitMQ.ini' /var/www/html/dev/ /var/www/html
	systemctl restart dbListener.service
	systemctl restart dmzListener.service
	echo "Changes pushed to QA."
elif [[ $VAR = "PROD" ]]
then
	rsync -av $HOME/git/IT490Proj/Environments/dev/dmzListener.php ~/git/IT490Proj/Environments/prod
        rsync -av $HOME/git/IT490Proj/Environments/dev/dbListener.php ~/git/IT490Proj/Environments/prod
        rsync -av --exclude='dbWebsiteRabbitMQ.ini' --exclude='dmzWebsiteRabbitMQ.ini' --exclude='dev/' --exclude='prod/' /var/www/html/ /var/www/html/prod
	systemctl restart prodDBListener.service
        systemctl restart prodDMZListener.service
	echo "Changes pushed to Production."
else
	echo "Invalid argument given, terminating deployment." 
fi

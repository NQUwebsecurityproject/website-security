# !/bin/bash
cat /var/log/httpd/tecminttest-acces-log | grep "$(env LANG=en_US date '+%d/%b/%Y:%H:%M')" > log.txt
ip=$(cat log.txt | grep POST | grep wp-login.php | awk {'print $1'} | sort | uniq)

if [ -z "$ip" ]; then
    echo -e "\n!There's no people using hydra to hack you."
else
    count=$(echo $ip | awk {'print NF'})
    echo -e "\n! YOU BEEN HACKED:\n  potential hacker(s): $count"
    if [ $count -gt 1 ]; then
        for i in $(seq 1 $count);
        do
            ip1=$(echo $ip | awk "{print \$$i}")
            time=$(cat log.txt | grep POST | grep wp-login.php | grep -c $ip1\ )
            echo -e "  - hacker IP: $ip1\n    brute forse time: $time"
            if [ $time -gt 25 -a ! -z "$ip1" ]; then
                iptables -C INPUT -s $ip1 -j DROP
                if ! [ $(echo $?) -eq 0 ]; then
                    iptables -A INPUT -s $ip1 -j DROP
                    echo -e "\nBLOCK $ip1\n"
                else
                    echo -e "\nALREADY BLOCKED $ip1\n"
                fi
            fi
        done
        echo -e "END"
    else
        ip=$(echo $ip)
        time=$(cat log.txt | grep POST | grep wp-login.php | grep -c $ip)
        echo -e "\n  - hacker IP: $ip\n    brute forse time: $time\nEND"
        if [ $time -gt 25 ]; then
            iptables -C INPUT -s $ip -j DROP
            if ! [ $(echo $?) -eq 0 ]; then
                iptables -A INPUT -s $ip -j DROP
                echo -e "\nBLOCK $ip\n"
            else
                echo -e "\nALREADY BLOCKED $ip\n"
            fi
        fi
    fi
fi


FROM phusion/baseimage:0.9.12
MAINTAINER Y12STUDIO <y12studio@gmail.com>

ENV HOME /root
ENV LANG zh_TW.UTF-8
ENV DEBIAN_FRONTEND noninteractive
# Use UTF-8 locale inside the container
RUN locale-gen zh_TW.UTF-8
# Use the phusion baseimage's insecure key
RUN /usr/sbin/enable_insecure_key

RUN apt-get update -y
RUN apt-get install -y curl wget python git unzip nginx pwgen

# install hhvm
RUN wget -O - http://dl.hhvm.com/conf/hhvm.gpg.key | apt-key add -
RUN echo deb http://dl.hhvm.com/ubuntu trusty main | tee /etc/apt/sources.list.d/hhvm.list
RUN apt-get update
RUN apt-get install -y hhvm

# install wordpress
RUN cd /tmp && curl http://wordpress.org/latest.tar.gz | tar -zxvf - && mv wordpress /mnt/hhvm

# nginx
RUN echo "daemon off;" >> /etc/nginx/nginx.conf
ADD nginx-default /etc/nginx/sites-available/default
ADD nginx.sh /etc/service/nginx/run
RUN chmod +x /etc/service/nginx/run

#hhvm
ADD hhvm.sh /etc/service/hhvm/run
RUN chmod +x /etc/service/hhvm/run
RUN /usr/share/hhvm/install_fastcgi.sh

# webpage
# ADD index.hh /mnt/hhvm/index.hh
ADD wpinit.sh /etc/my_init.d/wpinit.sh
RUN chmod +x /etc/my_init.d/wpinit.sh

# expose port 80
EXPOSE 80
CMD ["/sbin/my_init"]
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
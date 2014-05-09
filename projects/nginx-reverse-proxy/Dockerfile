FROM ubuntu:14.04

# Install Nginx.
RUN apt-get update && apt-get install -y nginx nano git curl wget
RUN echo "\ndaemon off;" >> /etc/nginx/nginx.conf

# /etc/nginx/sites-enabled/default
# root /usr/share/nginx/html;

ADD index.html /usr/share/nginx/html/

# override default conf
# ADD nginx.default /etc/nginx/sites-enabled/default


#
# Install Node.js
RUN apt-get install -y software-properties-common && \
    add-apt-repository -y ppa:chris-lea/node.js && \
	apt-get update && apt-get install -y nodejs &&\
	npm install -g grunt-cli

ADD package.json.inject /root/package.json
ADD Gruntfile.js.inject /root/
RUN cd /root && npm install

ADD yrunt.sh /
RUN chmod +x /yrunt.sh

WORKDIR /root

# Expose ports.
EXPOSE 80

# Define default command.
CMD ["nginx"]

all: zip

zip:
	cd ..; zip -9 -r apporder/apporder.zip apporder/ -x *.git* -x apporder.zip

zip-signed: sign
	cd /tmp/build; zip -9 -r apporder/apporder.zip apporder/ -x *.git* -x apporder.zip
	mv /tmp/build/apporder/apporder.zip ./

clean:
	rm apporder.zip
	rm -fr /tmp/build/apporder/

sign:
	mkdir -p /tmp/build/apporder/
	cp -R . /tmp/build/apporder/
	rm -fr /tmp/build/apporder/.git
	rm -fr /tmp/build/apporder/apporder.zip
	./../../occ integrity:sign-app --privateKey="/home/jus/build/owncloud/apporder.key" --certificate=/home/jus/build/owncloud/apporder.crt --path=/tmp/build/apporder

sign-git:
	./../../occ integrity:sign-app --privateKey="/home/jus/build/owncloud/apporder.key" --certificate=/home/jus/build/owncloud/apporder.crt --path=$(PWD)

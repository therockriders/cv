REMOTE ?= "rec"
build:
	bundle exec jekyll build

push:
	scp -r _site/* $(REMOTE):/var/www/cv/
	# rsync -avrz --delete-excluded _site/* $(REMOTE)

push_free:
	lftp ftp://jul.legall@ftpperso.free.fr -e "mirror -e --ignore-time -R _site cv; quit"

deploy: build push

deploy_free: build push_free

serve:
	bundle exec jekyll serve --drafts --watch
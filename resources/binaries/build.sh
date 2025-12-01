#!/usr/bin/env sh

echo "update marathon project "
rsync -rtv --exclude '.git'  . $NAME@marathon.ipa.iutlens.local:/srv/comptes/marathon24/$NAME/www/
ssh $NAME@marathon.ipa.iutlens.local "/srv/comptes/marathon24/$NAME/www/resources/binaries/install.sh"


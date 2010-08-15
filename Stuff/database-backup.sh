#!/bin/sh

# starting parameters selection
DATABASE_NAME=nets-x
DEST_FILENAME=/root/database-backup/netsx-db-mysql.dump
COMMIT_MESSAGE="Daily database backup"
SVN_PATH=http://www.nets-x.hs-bremen.de/svn/DatabaseBackup
SVN_AUTH="--username joao --password Bk5/e"

cd /root/database-backup

# svn checkout
# echo svn checkout $SVN_PATH $SVN_AUTH
svn checkout $SVN_PATH $SVN_AUTH

# svn update
# echo svn update $SVN_PATH $SVN_AUTH
svn update $SVN_PATH $SVN_AUTH

# dump the mysql database
# echo dumping database...
# mysqldump --user=root --password=rtk222 $DATABASE_NAME | gzip > $DEST_FILENAME
mysqldump --user=root --password=rtk222 $DATABASE_NAME > $DEST_FILENAME

# echo "compressing dump into ""${DEST_FILENAME}.tar.gz" "..."
tar -cvzf "${DEST_FILENAME}.tar.gz" $DEST_FILENAME

# copy file into svn folder
cp $DEST_FILENAME ./DatabaseBackup

# cd into Database folder
cd ./DatabaseBackup

# svn commit
# echo svn commit $SVN_AUTH -m '"'$COMMIT_MESSAGE'"'
svn commit $SVN_AUTH -m "$COMMIT_MESSAGE"

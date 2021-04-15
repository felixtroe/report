#!/usr/bin/env bash
. ".dbwebb/inspect-src/kmom.d/functions.bash"

cd $TARGET_DIR || exit 1

target="phpcpd"
#make $target >& /dev/null

file="build/$target"
lines=$( wc -l $file )

[[ $( grep "No clones found." $file ) ]]
doLog $? "$target: clones ($lines)"

#!/usr/bin/env bash

if [ -n "$POSTGRES_USE_RAM" ]
then
    function exit_when_error()
    {
        if [ "${1:-0}" -ne 0 ]
        then
            if [ -n "${2:-''}" ]
            then
                echo "$2 Выход."
            fi
            exit "$1"
        fi
    }

    SHARED_MEMORY_SIZE=512M
    PATH_TO_SHARED_RAM="/tmp/postgres_data"
    SOURCE_PATH="/var/lib/postgresql/data"

    echo "Prepare system to run in ram"
    if [ ! -d "$SOURCE_PATH.bac" ]
    then
        # Нет резервной копии
        echo "Copy data directory to backup"
        cp -rf "$SOURCE_PATH" "$SOURCE_PATH.bac"
    fi

    echo "Check already mounted"
    DATA=$(df -h -t tmpfs "$SOURCE_PATH" >/dev/null 2>&1 || echo "not found")
    if [ "$DATA" == "not found" ]
    then
        echo "Mount data directory to ram"
        # Не смонтированна директория
        mount -t tmpfs -o size="$SHARED_MEMORY_SIZE" tmpfs "$SOURCE_PATH" ||
            $(echo "Не смог смонтировать область памяти в директорию. Продолжение работы не возможно." && exit 1)
        echo "Copy data from backup to ram data directory"
        chown -R postgres: "$SOURCE_PATH"
        cp -r "$SOURCE_PATH.bac/*" "$SOURCE_PATH" && echo "OK"
    fi
    echo "Done"
fi

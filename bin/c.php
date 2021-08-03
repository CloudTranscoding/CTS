#!/bin/bash
INPUT=$1
OUTPUT=$2
VBIT=$3
ABIT=$4
ASS=$5
echo $ID $OUTPUT
mkdir -p $OUTPUT/{hls,hls/ts,mp4,img}
/usr/local/bin/ffmpeg -y -i "$INPUT" -threads 0 \
-c:v libx264 -maxrate 700k -bufsize 1400k -preset veryfast -vf "ass=360P_2.ass,scale=720:-1" -c:a aac -b:a 128k -map 0 -f ssegment -segment_format mpegts -segment_list $OUTPUT/hls/index.m3u8 -segment_time 10 $OUTPUT/hls/ts/'%03d.ts' \
-c:v libx264 -maxrate 700k -bufsize 1400k -preset veryfast -vf "ass=360P_2.ass,scale=720:-1" -c:a aac -b:a 128k -movflags faststart -f mp4 $OUTPUT/mp4/$ID.mp4



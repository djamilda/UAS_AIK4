from youtube_transcript_api import YouTubeTranscriptApi
import json

video_id = 'lx-xTinCAlA'
try:
    transcript = YouTubeTranscriptApi.get_transcript(video_id, languages=['id', 'en'])
    for entry in transcript:
        print(f"{entry['start']}s: {entry['text']}")
except Exception as e:
    print("Error:", e)

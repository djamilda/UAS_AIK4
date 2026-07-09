import urllib.request
import re
import json

url = 'https://www.youtube.com/watch?v=lx-xTinCAlA'
try:
    html = urllib.request.urlopen(url).read().decode('utf-8')
    # Try to find ytInitialPlayerResponse
    match = re.search(r'ytInitialData\s*=\s*(\{.*?\});\s*</script>', html)
    if match:
        data = json.loads(match.group(1))
        # Chapters are usually deep in the JSON
        print("Got ytInitialData")
        # Just dump a bunch of text looking for chapter titles
        text = match.group(1)
        chapters = re.findall(r'"title":\{"simpleText":"(.*?)"\},"timeRangeStartMillis":(\d+)', text)
        if chapters:
            print("Chapters found in ytInitialData:")
            for c in chapters:
                print(f"{c[0]}: {int(c[1])//1000}s")
        else:
            print("No chapters found using regex 1")
            
    match2 = re.search(r'ytInitialPlayerResponse\s*=\s*(\{.*?\});\s*(?:var|</script>)', html)
    if match2:
        print("Got ytInitialPlayerResponse")
        text = match2.group(1)
        chapters = re.findall(r'"title":\{"simpleText":"(.*?)"\},"timeRangeStartMillis":(\d+)', text)
        if chapters:
            print("Chapters found in ytInitialPlayerResponse:")
            for c in chapters:
                print(f"{c[0]}: {int(c[1])//1000}s")
        
        # Another pattern for chapters
        markers = re.findall(r'"chapterRenderer":\{"title":\{"simpleText":"(.*?)"\},"timeRangeStartMillis":(\d+)', text)
        if markers:
            print("Markers found:")
            for c in markers:
                print(f"{c[0]}: {int(c[1])//1000}s")
                
except Exception as e:
    print("Error:", e)

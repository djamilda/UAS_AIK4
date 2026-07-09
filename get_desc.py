import urllib.request
import re
import json

url = 'https://www.youtube.com/watch?v=lx-xTinCAlA'
try:
    html = urllib.request.urlopen(url).read().decode('utf-8')
    match = re.search(r'"shortDescription":"(.*?)"', html)
    if match:
        desc = match.group(1)
        desc = desc.replace('\\n', '\n').replace('\\"', '"')
        print(desc)
    else:
        print("No description found")
except Exception as e:
    print("Error:", e)

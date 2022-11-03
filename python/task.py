import datetime
import urllib.request, json
import sys


if __name__ == "__main__":
    print(datetime.datetime.now())
    if len(sys.argv) > 1:
        mode = sys.argv[1]
    else:
        mode = '0'

    if mode == '0':
        print("Mode: FAST")
    if mode == '1':
        print("Mode: FULL")

    with urllib.request.urlopen("http://web/import/url/"+mode) as url:
        data = json.load(url)
        for d in data:
            print(d)
            urllib.request.urlopen(d)

    print(datetime.datetime.now())

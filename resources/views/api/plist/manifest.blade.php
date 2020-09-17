<?xml version="1.0" encoding="UTF-8"?>
    <!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
<plist version="1.0">
    <dict>
        <key>items</key>
        <array>
            <dict>
                <key>assets</key>
                <array>
                    <dict>
                        <key>kind</key>
                        <string>software-package</string>
                        <key>url</key>
                        <string>{{ $appIpa }}</string>
                    </dict>
                    <dict>
                        <key>kind</key>
                        <string>display-image</string>
                        <key>url</key>
                        <string>{{ $appIcon }}</string>
                        {{--<string>{{ $publicUrl }}/image57</string>--}}
                    </dict>
                    <dict>
                        <key>kind</key>
                        <string>full-size-image</string>
                        <key>url</key>
                        <string>{{ $appIcon }}</string>
                        {{--<string>{{ $publicUrl }}/image512</string>--}}
                    </dict>
                </array>
                <key>metadata</key>
                <dict>
                    <key>bundle-identifier</key>
                    <string>{{ $appBundle }}</string>
                    <key>bundle-version</key>
                    <string>{{ $appVersion }}</string>
                    <key>kind</key>
                    <string>software</string>
                    <key>title</key>
                    <string>{{ $appName }}</string>
                </dict>
            </dict>
        </array>
    </dict>
</plist>

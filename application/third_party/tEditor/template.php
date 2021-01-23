#config-version=FGT40F-6.0.6-FW-build0272-191025:opmode=0:vdom=0:user=admin
#conf_file_ver=155808528633268
#buildno=6478
#global_vdom=1
config system global
    set admin-sport 981
    set admintimeout 60
    set alias "FGT40FTK20041922"
    set hostname "<?=$client_num?>_<?=$client_name?>"
    set switch-controller enable
    set timezone 36
end
config system accprofile
    edit "prof_admin"
        set secfabgrp read-write
        set ftviewgrp read-write
        set authgrp read-write
        set sysgrp read-write
        set netgrp read-write
        set loggrp read-write
        set fwgrp read-write
        set vpngrp read-write
        set utmgrp read-write
        set wifi read-write
    next
end
config system np6xlite
    edit "np6xlite_0"
    next
end
config system interface
    edit "wan"
        set vdom "root"
        set ip <?=$wan_ip?> 255.255.255.248
        set allowaccess ping https ssh fgfm
        set type physical
        set alias "Untrust_<?=$phone_id?>"
        set role wan
        set snmp-index 1
    next
    edit "modem"
        set vdom "root"
        set mode pppoe
        set type physical
        set snmp-index 2
    next
    edit "ssl.root"
        set vdom "root"
        set type tunnel
        set alias "SSL VPN interface"
        set snmp-index 3
    next
    edit "lan"
        set vdom "root"
        set ip <?=$manbas_ip?>.254 255.255.255.0
        set allowaccess ping https ssh fgfm capwap
        set type hard-switch
        set alias "Manbas"
        set stp enable
        set device-identification enable
        set role lan
        set snmp-index 4
    next
    edit "Wifi"
        set vdom "root"
        set ip <?=$wi_fi_ip?>.254 255.255.255.0
        set allowaccess ping https ssh
        set type hard-switch
        set device-identification enable
        set role lan
        set snmp-index 7
    next
    edit "Pedagogy"
        set vdom "root"
        set ip <?=$pedagogy_ip?>.254 255.255.255.0
        set allowaccess ping https ssh
        set type hard-switch
        set device-identification enable
        set role lan
        set snmp-index 6
    next
end
config system physical-switch
    edit "sw0"
        set age-val 0
    next
end
config system virtual-switch
    edit "lan"
        set physical-switch "sw0"
        config port
            edit "lan1"
            next
        end
    next
    edit "Wifi"
        set physical-switch "sw0"
        config port
            edit "a"
            next
        end
    next
    edit "Pedagogy"
        set physical-switch "sw0"
        config port
            edit "lan2"
            next
            edit "lan3"
            next
        end
    next
end
config system custom-language
    edit "en"
        set filename "en"
    next
    edit "fr"
        set filename "fr"
    next
    edit "sp"
        set filename "sp"
    next
    edit "pg"
        set filename "pg"
    next
    edit "x-sjis"
        set filename "x-sjis"
    next
    edit "big5"
        set filename "big5"
    next
    edit "GB2312"
        set filename "GB2312"
    next
    edit "euc-kr"
        set filename "euc-kr"
    next
end
config system admin
    edit "admin"
        set accprofile "super_admin"
        set vdom "root"
        config gui-dashboard
            edit 1
                set name "Main"
                config widget
                    edit 1
                        set x-pos 1
                        set y-pos 1
                        set width 1
                        set height 1
                    next
                    edit 2
                        set type licinfo
                        set x-pos 2
                        set y-pos 1
                        set width 1
                        set height 1
                    next
                    edit 3
                        set type forticloud
                        set x-pos 3
                        set y-pos 1
                        set width 1
                        set height 1
                    next
                    edit 4
                        set type security-fabric
                        set x-pos 4
                        set y-pos 1
                        set width 1
                        set height 1
                    next
                    edit 5
                        set type security-fabric-ranking
                        set x-pos 5
                        set y-pos 1
                        set width 1
                        set height 1
                    next
                    edit 6
                        set type admins
                        set x-pos 6
                        set y-pos 1
                        set width 1
                        set height 1
                    next
                    edit 7
                        set type cpu-usage
                        set x-pos 7
                        set y-pos 1
                        set width 2
                        set height 1
                    next
                    edit 8
                        set type memory-usage
                        set x-pos 8
                        set y-pos 1
                        set width 2
                        set height 1
                    next
                    edit 9
                        set type sessions
                        set x-pos 9
                        set y-pos 1
                        set width 2
                        set height 1
                    next
                end
            next
        end
        set password ENC SH261NE4xHShITyJArxBP7oVEeKw4JwbbErQOBJlrRKz3q+P3X1lM+tjOHnVgQ=
    next
end
config system ha
    set override disable
end
config system dns
    set primary 208.91.112.53
    set secondary 208.91.112.52
end
config system replacemsg-image
    edit "logo_fnet"
        set image-type gif
        set image-base64 ''
    next
    edit "logo_fguard_wf"
        set image-type gif
        set image-base64 ''
    next
    edit "logo_fw_auth"
        set image-base64 ''
    next
    edit "logo_v2_fnet"
        set image-base64 ''
    next
    edit "logo_v2_fguard_wf"
        set image-base64 ''
    next
    edit "logo_v2_fguard_app"
        set image-base64 ''
    next
end
config system replacemsg mail "email-av-fail"
end
config system replacemsg mail "email-block"
end
config system replacemsg mail "email-dlp-subject"
end
config system replacemsg mail "email-dlp-ban"
end
config system replacemsg mail "email-filesize"
end
config system replacemsg mail "partial"
end
config system replacemsg mail "smtp-block"
end
config system replacemsg mail "smtp-filesize"
end
config system replacemsg mail "email-decompress-limit"
end
config system replacemsg mail "smtp-decompress-limit"
end
config system replacemsg http "bannedword"
end
config system replacemsg http "url-block"
end
config system replacemsg http "urlfilter-err"
end
config system replacemsg http "infcache-block"
end
config system replacemsg http "http-block"
end
config system replacemsg http "http-filesize"
end
config system replacemsg http "http-dlp-ban"
end
config system replacemsg http "http-archive-block"
end
config system replacemsg http "http-contenttypeblock"
end
config system replacemsg http "https-invalid-cert-block"
end
config system replacemsg http "http-client-block"
end
config system replacemsg http "http-client-filesize"
end
config system replacemsg http "http-client-bannedword"
end
config system replacemsg http "http-post-block"
end
config system replacemsg http "http-client-archive-block"
end
config system replacemsg http "switching-protocols-block"
end
config system replacemsg webproxy "deny"
end
config system replacemsg webproxy "user-limit"
end
config system replacemsg webproxy "auth-challenge"
end
config system replacemsg webproxy "auth-login-fail"
end
config system replacemsg webproxy "auth-group-info-fail"
end
config system replacemsg webproxy "http-err"
end
config system replacemsg webproxy "auth-ip-blackout"
end
config system replacemsg ftp "ftp-av-fail"
end
config system replacemsg ftp "ftp-dl-blocked"
end
config system replacemsg ftp "ftp-dl-filesize"
end
config system replacemsg ftp "ftp-dl-dlp-ban"
end
config system replacemsg ftp "ftp-explicit-banner"
end
config system replacemsg ftp "ftp-dl-archive-block"
end
config system replacemsg nntp "nntp-av-fail"
end
config system replacemsg nntp "nntp-dl-blocked"
end
config system replacemsg nntp "nntp-dl-filesize"
end
config system replacemsg nntp "nntp-dlp-subject"
end
config system replacemsg nntp "nntp-dlp-ban"
end
config system replacemsg nntp "email-decompress-limit"
end
config system replacemsg fortiguard-wf "ftgd-block"
end
config system replacemsg fortiguard-wf "http-err"
end
config system replacemsg fortiguard-wf "ftgd-ovrd"
end
config system replacemsg fortiguard-wf "ftgd-quota"
end
config system replacemsg fortiguard-wf "ftgd-warning"
end
config system replacemsg spam "ipblocklist"
end
config system replacemsg spam "smtp-spam-dnsbl"
end
config system replacemsg spam "smtp-spam-feip"
end
config system replacemsg spam "smtp-spam-helo"
end
config system replacemsg spam "smtp-spam-emailblack"
end
config system replacemsg spam "smtp-spam-mimeheader"
end
config system replacemsg spam "reversedns"
end
config system replacemsg spam "smtp-spam-bannedword"
end
config system replacemsg spam "smtp-spam-ase"
end
config system replacemsg spam "submit"
end
config system replacemsg alertmail "alertmail-virus"
end
config system replacemsg alertmail "alertmail-block"
end
config system replacemsg alertmail "alertmail-nids-event"
end
config system replacemsg alertmail "alertmail-crit-event"
end
config system replacemsg alertmail "alertmail-disk-full"
end
config system replacemsg admin "pre_admin-disclaimer-text"
end
config system replacemsg admin "post_admin-disclaimer-text"
end
config system replacemsg auth "auth-disclaimer-page-1"
end
config system replacemsg auth "auth-disclaimer-page-2"
end
config system replacemsg auth "auth-disclaimer-page-3"
end
config system replacemsg auth "auth-reject-page"
end
config system replacemsg auth "auth-login-page"
end
config system replacemsg auth "auth-login-failed-page"
end
config system replacemsg auth "auth-token-login-page"
end
config system replacemsg auth "auth-token-login-failed-page"
end
config system replacemsg auth "auth-success-msg"
end
config system replacemsg auth "auth-challenge-page"
end
config system replacemsg auth "auth-keepalive-page"
end
config system replacemsg auth "auth-portal-page"
end
config system replacemsg auth "auth-password-page"
end
config system replacemsg auth "auth-fortitoken-page"
end
config system replacemsg auth "auth-next-fortitoken-page"
end
config system replacemsg auth "auth-email-token-page"
end
config system replacemsg auth "auth-sms-token-page"
end
config system replacemsg auth "auth-email-harvesting-page"
end
config system replacemsg auth "auth-email-failed-page"
end
config system replacemsg auth "auth-cert-passwd-page"
end
config system replacemsg auth "auth-guest-print-page"
end
config system replacemsg auth "auth-guest-email-page"
end
config system replacemsg auth "auth-success-page"
end
config system replacemsg auth "auth-block-notification-page"
end
config system replacemsg auth "auth-quarantine-page"
end
config system replacemsg auth "auth-qtn-reject-page"
end
config system replacemsg sslvpn "sslvpn-login"
end
config system replacemsg sslvpn "sslvpn-header"
end
config system replacemsg sslvpn "sslvpn-limit"
end
config system replacemsg sslvpn "hostcheck-error"
end
config system replacemsg ec "endpt-download-portal"
end
config system replacemsg ec "endpt-download-portal-mac"
end
config system replacemsg ec "endpt-download-portal-linux"
end
config system replacemsg ec "endpt-download-portal-ios"
end
config system replacemsg ec "endpt-download-portal-aos"
end
config system replacemsg ec "endpt-download-portal-other"
end
config system replacemsg ec "endpt-warning-portal"
end
config system replacemsg ec "endpt-warning-portal-mac"
end
config system replacemsg ec "endpt-warning-portal-linux"
end
config system replacemsg ec "endpt-remedy-inst"
end
config system replacemsg ec "endpt-remedy-reg"
end
config system replacemsg ec "endpt-remedy-ftcl-autofix"
end
config system replacemsg ec "endpt-remedy-av-3rdp"
end
config system replacemsg ec "endpt-remedy-ver"
end
config system replacemsg ec "endpt-remedy-os-ver"
end
config system replacemsg ec "endpt-remedy-vuln"
end
config system replacemsg ec "endpt-remedy-sig-ids"
end
config system replacemsg ec "endpt-remedy-ems-online"
end
config system replacemsg ec "endpt-ftcl-incompat"
end
config system replacemsg ec "endpt-download-ftcl"
end
config system replacemsg ec "endpt-quarantine-portal"
end
config system replacemsg device-detection-portal "device-detection-failure"
end
config system replacemsg nac-quar "nac-quar-virus"
end
config system replacemsg nac-quar "nac-quar-dos"
end
config system replacemsg nac-quar "nac-quar-ips"
end
config system replacemsg nac-quar "nac-quar-dlp"
end
config system replacemsg nac-quar "nac-quar-admin"
end
config system replacemsg nac-quar "nac-quar-app"
end
config system replacemsg traffic-quota "per-ip-shaper-block"
end
config system replacemsg utm "virus-html"
end
config system replacemsg utm "client-virus-html"
end
config system replacemsg utm "virus-text"
end
config system replacemsg utm "dlp-html"
end
config system replacemsg utm "dlp-text"
end
config system replacemsg utm "appblk-html"
end
config system replacemsg utm "ipsblk-html"
end
config system replacemsg utm "ipsfail-html"
end
config system replacemsg utm "exe-text"
end
config system replacemsg utm "waf-html"
end
config system replacemsg utm "outbreak-prevention-html"
end
config system replacemsg utm "outbreak-prevention-text"
end
config system replacemsg icap "icap-req-resp"
end
config system snmp sysinfo
    set status enable
    set description "413823"
    set contact-info "Bezeq International Support Team"
end
config system snmp community
    edit 1
        set name "NMSRO"
        config hosts
            edit 1
                set ip 192.168.10.11 255.255.255.255
            next
        end
    next
end
config system central-management
    set type fortiguard
end
config user device-category
    edit "android-phone"
    next
    edit "android-tablet"
    next
    edit "blackberry-phone"
    next
    edit "blackberry-playbook"
    next
    edit "forticam"
    next
    edit "fortifone"
    next
    edit "fortinet"
    next
    edit "gaming-console"
    next
    edit "ip-phone"
    next
    edit "ipad"
    next
    edit "iphone"
    next
    edit "linux-pc"
    next
    edit "mac"
    next
    edit "media-streaming"
    next
    edit "printer"
    next
    edit "router-nat-device"
    next
    edit "windows-pc"
    next
    edit "windows-phone"
    next
    edit "windows-tablet"
    next
    edit "other-network-device"
    next
    edit "collected-emails"
    next
    edit "amazon-device"
    next
    edit "android-device"
    next
    edit "blackberry-device"
    next
    edit "fortinet-device"
    next
    edit "ios-device"
    next
    edit "windows-device"
    next
    edit "all"
    next
end
config system cluster-sync
end
config system fortiguard
    set sdns-server-ip "208.91.112.220" 
end
config ips global
end
config system email-server
    set server "notification.fortinet.net"
    set port 465
    set security smtps
end
config system session-helper
    edit 1
        set name pptp
        set protocol 6
        set port 1723
    next
    edit 2
        set name h323
        set protocol 6
        set port 1720
    next
    edit 3
        set name ras
        set protocol 17
        set port 1719
    next
    edit 4
        set name tns
        set protocol 6
        set port 1521
    next
    edit 5
        set name tftp
        set protocol 17
        set port 69
    next
    edit 6
        set name rtsp
        set protocol 6
        set port 554
    next
    edit 7
        set name rtsp
        set protocol 6
        set port 7070
    next
    edit 8
        set name rtsp
        set protocol 6
        set port 8554
    next
    edit 9
        set name ftp
        set protocol 6
        set port 21
    next
    edit 10
        set name mms
        set protocol 6
        set port 1863
    next
    edit 11
        set name pmap
        set protocol 6
        set port 111
    next
    edit 12
        set name pmap
        set protocol 17
        set port 111
    next
    edit 13
        set name sip
        set protocol 17
        set port 5060
    next
    edit 14
        set name dns-udp
        set protocol 17
        set port 53
    next
    edit 15
        set name rsh
        set protocol 6
        set port 514
    next
    edit 16
        set name rsh
        set protocol 6
        set port 512
    next
    edit 17
        set name dcerpc
        set protocol 6
        set port 135
    next
    edit 18
        set name dcerpc
        set protocol 17
        set port 135
    next
    edit 19
        set name mgcp
        set protocol 17
        set port 2427
    next
    edit 20
        set name mgcp
        set protocol 17
        set port 2727
    next
end
config system auto-install
    set auto-install-config enable
    set auto-install-image enable
end
config system ntp
    set ntpsync enable
    set server-mode enable
    set interface "wan"
end
config system object-tagging
    edit "default"
    next
end
config system settings
    set inspection-mode flow
end
config system dhcp server
    edit 3
        set dns-service default
        set default-gateway <?=$manbas_ip?>.254
        set netmask 255.255.255.0
        set interface "lan"
        config ip-range
            edit 1
                set start-ip <?=$manbas_ip?>.1
                set end-ip <?=$manbas_ip?>.249
            next
        end
        set timezone-option default
        config reserved-address
            edit 1
                set ip <?=$manbas_ip?>.249
                set mac <?=$clock_mac.PHP_EOL?>
                set description "Clock"
            next
        end
    next
    edit 5
        set dns-service default
        set default-gateway <?=$wi_fi_ip?>.254
        set netmask 255.255.255.0
        set interface "Wifi"
        config ip-range
            edit 1
                set start-ip <?=$wi_fi_ip?>.1
                set end-ip <?=$wi_fi_ip?>.253
            next
        end
        set timezone-option default
    next
    edit 4
        set dns-service default
        set default-gateway <?=$pedagogy_ip?>.254
        set netmask 255.255.255.0
        set interface "Pedagogy"
        config ip-range
            edit 1
                set start-ip <?=$pedagogy_ip?>.1
                set end-ip <?=$pedagogy_ip?>.253
            next
        end
        set timezone-option default
    next
end
config firewall address
    edit "none"
        set uuid 66a03ec8-db5c-51ea-ccbd-6faf61804421
        set subnet 0.0.0.0 255.255.255.255
    next
    edit "all"
        set uuid 67833192-db5c-51ea-ad1c-9897e74ecad5
    next
    edit "FIREWALL_AUTH_PORTAL_ADDRESS"
        set uuid 67833976-db5c-51ea-b2ca-1d8f5f6ce960
        set visibility disable
    next
    edit "SSLVPN_TUNNEL_ADDR1"
        set uuid 6785152a-db5c-51ea-a37a-31f0c8727a4c
        set type iprange
        set associated-interface "ssl.root"
        set start-ip 10.212.134.200
        set end-ip 10.212.134.210
    next
    edit "<?=$manbas_ip?>.254"
        set uuid 37b53e00-54b1-51eb-61a0-8a7d6c607e23
        set subnet <?=$manbas_ip?>.254 255.255.255.255
    next
    edit "Clock"
        set uuid 47dbc628-54b1-51eb-17f4-ff80aecaa8d6
        set subnet <?=$manbas_ip?>.249 255.255.255.255
    next
    edit "<?=$pedagogy_ip?>.254"
        set uuid 7148e2b6-54b1-51eb-f490-ca14f76a118f
        set subnet <?=$pedagogy_ip?>.254 255.255.255.255
    next
    edit "<?=$wi_fi_ip?>.254"
        set uuid 8f0d29b0-54b1-51eb-95bd-66dd70ccbe95
        set subnet <?=$wi_fi_ip?>.254 255.255.255.255
    next
end
config firewall multicast-address
    edit "all"
        set start-ip 224.0.0.0
        set end-ip 239.255.255.255
    next
    edit "all_hosts"
        set start-ip 224.0.0.1
        set end-ip 224.0.0.1
    next
    edit "all_routers"
        set start-ip 224.0.0.2
        set end-ip 224.0.0.2
    next
    edit "Bonjour"
        set start-ip 224.0.0.251
        set end-ip 224.0.0.251
    next
    edit "EIGRP"
        set start-ip 224.0.0.10
        set end-ip 224.0.0.10
    next
    edit "OSPF"
        set start-ip 224.0.0.5
        set end-ip 224.0.0.6
    next
end
config firewall address6
    edit "SSLVPN_TUNNEL_IPv6_ADDR1"
        set uuid 67852236-db5c-51ea-df9b-2938ad3efa1b
        set ip6 fdff:ffff::/120
    next
    edit "all"
        set uuid 6c5cb5e4-db5c-51ea-3384-bb950ab57e9a
    next
    edit "none"
        set uuid 6c5ce0f0-db5c-51ea-9dfb-2bfd21e03a73
        set ip6 ::/128
    next
end
config firewall multicast-address6
    edit "all"
        set ip6 ff00::/8
    next
end
config firewall wildcard-fqdn custom
    edit "adobe"
        set uuid 6789a8b0-db5c-51ea-5d1c-fce3fba0c2df
        set wildcard-fqdn "*.adobe.com"
    next
    edit "Adobe Login"
        set uuid 6789ae5a-db5c-51ea-b5e6-589a538b4c2f
        set wildcard-fqdn "*.adobelogin.com"
    next
    edit "android"
        set uuid 6789b3aa-db5c-51ea-674b-d6410d6c3e3e
        set wildcard-fqdn "*.android.com"
    next
    edit "apple"
        set uuid 6789b8f0-db5c-51ea-5b5f-333c50c217dc
        set wildcard-fqdn "*.apple.com"
    next
    edit "appstore"
        set uuid 6789be40-db5c-51ea-6df2-0c195d9e2279
        set wildcard-fqdn "*.appstore.com"
    next
    edit "auth.gfx.ms"
        set uuid 6789c41c-db5c-51ea-9eaf-21a5f3c0acbc
        set wildcard-fqdn "*.auth.gfx.ms"
    next
    edit "citrix"
        set uuid 6789c976-db5c-51ea-026e-12373b5ad9a3
        set wildcard-fqdn "*.citrixonline.com"
    next
    edit "dropbox.com"
        set uuid 6789cec6-db5c-51ea-607a-1fb2ff528cea
        set wildcard-fqdn "*.dropbox.com"
    next
    edit "eease"
        set uuid 6789d420-db5c-51ea-47c0-6844b0b69a55
        set wildcard-fqdn "*.eease.com"
    next
    edit "firefox update server"
        set uuid 6789d97a-db5c-51ea-7154-270045304538
        set wildcard-fqdn "aus*.mozilla.org"
    next
    edit "fortinet"
        set uuid 6789dede-db5c-51ea-f0bd-b43b017097d5
        set wildcard-fqdn "*.fortinet.com"
    next
    edit "googleapis.com"
        set uuid 6789e492-db5c-51ea-e275-e10aaaeb02f4
        set wildcard-fqdn "*.googleapis.com"
    next
    edit "google-drive"
        set uuid 6789ea0a-db5c-51ea-937f-6d92bb99e76e
        set wildcard-fqdn "*drive.google.com"
    next
    edit "google-play2"
        set uuid 6789ef78-db5c-51ea-a183-4a26bb1e6002
        set wildcard-fqdn "*.ggpht.com"
    next
    edit "google-play3"
        set uuid 6789f4dc-db5c-51ea-ad9f-1e6a92e25a8f
        set wildcard-fqdn "*.books.google.com"
    next
    edit "Gotomeeting"
        set uuid 6789fb12-db5c-51ea-e581-786bab1174a4
        set wildcard-fqdn "*.gotomeeting.com"
    next
    edit "icloud"
        set uuid 678a040e-db5c-51ea-880b-ac48452cead6
        set wildcard-fqdn "*.icloud.com"
    next
    edit "itunes"
        set uuid 678a09cc-db5c-51ea-86ae-0ad159f525ac
        set wildcard-fqdn "*itunes.apple.com"
    next
    edit "microsoft"
        set uuid 678a0f3a-db5c-51ea-f17c-b5fb7aecec49
        set wildcard-fqdn "*.microsoft.com"
    next
    edit "skype"
        set uuid 678a14a8-db5c-51ea-9614-e7c281321a6d
        set wildcard-fqdn "*.messenger.live.com"
    next
    edit "softwareupdate.vmware.com"
        set uuid 678a1a0c-db5c-51ea-6b8d-d6f28b08e842
        set wildcard-fqdn "*.softwareupdate.vmware.com"
    next
    edit "verisign"
        set uuid 678a1f84-db5c-51ea-ffbb-5b46434b10ce
        set wildcard-fqdn "*.verisign.com"
    next
    edit "Windows update 2"
        set uuid 678a24fc-db5c-51ea-bd7a-c328acd370ea
        set wildcard-fqdn "*.windowsupdate.com"
    next
    edit "live.com"
        set uuid 678a2a6a-db5c-51ea-83fd-0e204122e86e
        set wildcard-fqdn "*.live.com"
    next
    edit "google-play"
        set uuid 678a2fec-db5c-51ea-6b05-89c3f523c995
        set wildcard-fqdn "*play.google.com"
    next
    edit "update.microsoft.com"
        set uuid 678a356e-db5c-51ea-00d7-845e97e935e1
        set wildcard-fqdn "*update.microsoft.com"
    next
    edit "swscan.apple.com"
        set uuid 678a3b36-db5c-51ea-b3c4-b94bb5ad8c79
        set wildcard-fqdn "*swscan.apple.com"
    next
    edit "autoupdate.opera.com"
        set uuid 678a40b8-db5c-51ea-5d1f-3911fecc7aac
        set wildcard-fqdn "*autoupdate.opera.com"
    next
end
config firewall service category
    edit "General"
        set comment "General services."
    next
    edit "Web Access"
        set comment "Web access."
    next
    edit "File Access"
        set comment "File access."
    next
    edit "Email"
        set comment "Email services."
    next
    edit "Network Services"
        set comment "Network services."
    next
    edit "Authentication"
        set comment "Authentication service."
    next
    edit "Remote Access"
        set comment "Remote access."
    next
    edit "Tunneling"
        set comment "Tunneling service."
    next
    edit "VoIP, Messaging & Other Applications"
        set comment "VoIP, messaging, and other applications."
    next
    edit "Web Proxy"
        set comment "Explicit web proxy."
    next
end
config firewall service custom
    edit "ALL"
        set category "General"
        set protocol IP
    next
    edit "ALL_TCP"
        set category "General"
        set tcp-portrange 1-65535
    next
    edit "ALL_UDP"
        set category "General"
        set udp-portrange 1-65535
    next
    edit "ALL_ICMP"
        set category "General"
        set protocol ICMP
        unset icmptype
    next
    edit "ALL_ICMP6"
        set category "General"
        set protocol ICMP6
        unset icmptype
    next
    edit "GRE"
        set category "Tunneling"
        set protocol IP
        set protocol-number 47
    next
    edit "AH"
        set category "Tunneling"
        set protocol IP
        set protocol-number 51
    next
    edit "ESP"
        set category "Tunneling"
        set protocol IP
        set protocol-number 50
    next
    edit "AOL"
        set visibility disable
        set tcp-portrange 5190-5194
    next
    edit "BGP"
        set category "Network Services"
        set tcp-portrange 179
    next
    edit "DHCP"
        set category "Network Services"
        set udp-portrange 67-68
    next
    edit "DNS"
        set category "Network Services"
        set tcp-portrange 53
        set udp-portrange 53
    next
    edit "FINGER"
        set visibility disable
        set tcp-portrange 79
    next
    edit "FTP"
        set category "File Access"
        set tcp-portrange 21
    next
    edit "FTP_GET"
        set category "File Access"
        set tcp-portrange 21
    next
    edit "FTP_PUT"
        set category "File Access"
        set tcp-portrange 21
    next
    edit "GOPHER"
        set visibility disable
        set tcp-portrange 70
    next
    edit "H323"
        set category "VoIP, Messaging & Other Applications"
        set tcp-portrange 1720 1503
        set udp-portrange 1719
    next
    edit "HTTP"
        set category "Web Access"
        set tcp-portrange 80
    next
    edit "HTTPS"
        set category "Web Access"
        set tcp-portrange 443
    next
    edit "IKE"
        set category "Tunneling"
        set udp-portrange 500 4500
    next
    edit "IMAP"
        set category "Email"
        set tcp-portrange 143
    next
    edit "IMAPS"
        set category "Email"
        set tcp-portrange 993
    next
    edit "Internet-Locator-Service"
        set visibility disable
        set tcp-portrange 389
    next
    edit "IRC"
        set category "VoIP, Messaging & Other Applications"
        set tcp-portrange 6660-6669
    next
    edit "L2TP"
        set category "Tunneling"
        set tcp-portrange 1701
        set udp-portrange 1701
    next
    edit "LDAP"
        set category "Authentication"
        set tcp-portrange 389
    next
    edit "NetMeeting"
        set visibility disable
        set tcp-portrange 1720
    next
    edit "NFS"
        set category "File Access"
        set tcp-portrange 111 2049
        set udp-portrange 111 2049
    next
    edit "NNTP"
        set visibility disable
        set tcp-portrange 119
    next
    edit "NTP"
        set category "Network Services"
        set tcp-portrange 123
        set udp-portrange 123
    next
    edit "OSPF"
        set category "Network Services"
        set protocol IP
        set protocol-number 89
    next
    edit "PC-Anywhere"
        set category "Remote Access"
        set tcp-portrange 5631
        set udp-portrange 5632
    next
    edit "PING"
        set category "Network Services"
        set protocol ICMP
        set icmptype 8
        unset icmpcode
    next
    edit "TIMESTAMP"
        set protocol ICMP
        set visibility disable
        set icmptype 13
        unset icmpcode
    next
    edit "INFO_REQUEST"
        set protocol ICMP
        set visibility disable
        set icmptype 15
        unset icmpcode
    next
    edit "INFO_ADDRESS"
        set protocol ICMP
        set visibility disable
        set icmptype 17
        unset icmpcode
    next
    edit "ONC-RPC"
        set category "Remote Access"
        set tcp-portrange 111
        set udp-portrange 111
    next
    edit "DCE-RPC"
        set category "Remote Access"
        set tcp-portrange 135
        set udp-portrange 135
    next
    edit "POP3"
        set category "Email"
        set tcp-portrange 110
    next
    edit "POP3S"
        set category "Email"
        set tcp-portrange 995
    next
    edit "PPTP"
        set category "Tunneling"
        set tcp-portrange 1723
    next
    edit "QUAKE"
        set visibility disable
        set udp-portrange 26000 27000 27910 27960
    next
    edit "RAUDIO"
        set visibility disable
        set udp-portrange 7070
    next
    edit "REXEC"
        set visibility disable
        set tcp-portrange 512
    next
    edit "RIP"
        set category "Network Services"
        set udp-portrange 520
    next
    edit "RLOGIN"
        set visibility disable
        set tcp-portrange 513:512-1023
    next
    edit "RSH"
        set visibility disable
        set tcp-portrange 514:512-1023
    next
    edit "SCCP"
        set category "VoIP, Messaging & Other Applications"
        set tcp-portrange 2000
    next
    edit "SIP"
        set category "VoIP, Messaging & Other Applications"
        set tcp-portrange 5060
        set udp-portrange 5060
    next
    edit "SIP-MSNmessenger"
        set category "VoIP, Messaging & Other Applications"
        set tcp-portrange 1863
    next
    edit "SAMBA"
        set category "File Access"
        set tcp-portrange 139
    next
    edit "SMTP"
        set category "Email"
        set tcp-portrange 25
    next
    edit "SMTPS"
        set category "Email"
        set tcp-portrange 465
    next
    edit "SNMP"
        set category "Network Services"
        set tcp-portrange 161-162
        set udp-portrange 161-162
    next
    edit "SSH"
        set category "Remote Access"
        set tcp-portrange 22
    next
    edit "SYSLOG"
        set category "Network Services"
        set udp-portrange 514
    next
    edit "TALK"
        set visibility disable
        set udp-portrange 517-518
    next
    edit "TELNET"
        set category "Remote Access"
        set tcp-portrange 23
    next
    edit "TFTP"
        set category "File Access"
        set udp-portrange 69
    next
    edit "MGCP"
        set visibility disable
        set udp-portrange 2427 2727
    next
    edit "UUCP"
        set visibility disable
        set tcp-portrange 540
    next
    edit "VDOLIVE"
        set visibility disable
        set tcp-portrange 7000-7010
    next
    edit "WAIS"
        set visibility disable
        set tcp-portrange 210
    next
    edit "WINFRAME"
        set visibility disable
        set tcp-portrange 1494 2598
    next
    edit "X-WINDOWS"
        set category "Remote Access"
        set tcp-portrange 6000-6063
    next
    edit "PING6"
        set protocol ICMP6
        set visibility disable
        set icmptype 128
        unset icmpcode
    next
    edit "MS-SQL"
        set category "VoIP, Messaging & Other Applications"
        set tcp-portrange 1433 1434
    next
    edit "MYSQL"
        set category "VoIP, Messaging & Other Applications"
        set tcp-portrange 3306
    next
    edit "RDP"
        set category "Remote Access"
        set tcp-portrange 3389
    next
    edit "VNC"
        set category "Remote Access"
        set tcp-portrange 5900
    next
    edit "DHCP6"
        set category "Network Services"
        set udp-portrange 546 547
    next
    edit "SQUID"
        set category "Tunneling"
        set tcp-portrange 3128
    next
    edit "SOCKS"
        set category "Tunneling"
        set tcp-portrange 1080
        set udp-portrange 1080
    next
    edit "WINS"
        set category "Remote Access"
        set tcp-portrange 1512
        set udp-portrange 1512
    next
    edit "RADIUS"
        set category "Authentication"
        set udp-portrange 1812 1813
    next
    edit "RADIUS-OLD"
        set visibility disable
        set udp-portrange 1645 1646
    next
    edit "CVSPSERVER"
        set visibility disable
        set tcp-portrange 2401
        set udp-portrange 2401
    next
    edit "AFS3"
        set category "File Access"
        set tcp-portrange 7000-7009
        set udp-portrange 7000-7009
    next
    edit "TRACEROUTE"
        set category "Network Services"
        set udp-portrange 33434-33535
    next
    edit "RTSP"
        set category "VoIP, Messaging & Other Applications"
        set tcp-portrange 554 7070 8554
        set udp-portrange 554
    next
    edit "MMS"
        set visibility disable
        set tcp-portrange 1755
        set udp-portrange 1024-5000
    next
    edit "KERBEROS"
        set category "Authentication"
        set tcp-portrange 88 464
        set udp-portrange 88 464
    next
    edit "LDAP_UDP"
        set category "Authentication"
        set udp-portrange 389
    next
    edit "SMB"
        set category "File Access"
        set tcp-portrange 445
    next
    edit "NONE"
        set visibility disable
        set tcp-portrange 0
    next
    edit "webproxy"
        set proxy enable
        set category "Web Proxy"
        set protocol ALL
        set tcp-portrange 0-65535:0-65535
    next
end
config firewall service group
    edit "Email Access"
        set member "DNS" "IMAP" "IMAPS" "POP3" "POP3S" "SMTP" "SMTPS"
    next
    edit "Web Access"
        set member "DNS" "HTTP" "HTTPS"
    next
    edit "Windows AD"
        set member "DCE-RPC" "DNS" "KERBEROS" "LDAP" "LDAP_UDP" "SAMBA" "SMB"
    next
    edit "Exchange Server"
        set member "DCE-RPC" "DNS" "HTTPS"
    next
end
config webfilter ftgd-local-cat
    edit "custom1"
        set id 140
    next
    edit "custom2"
        set id 141
    next
end
config ips sensor
    edit "default"
        set comment "Prevent critical attacks."
        config entries
            edit 1
                set severity medium high critical 
            next
        end
    next
    edit "sniffer-profile"
        set comment "Monitor IPS attacks."
        config entries
            edit 1
                set severity medium high critical 
            next
        end
    next
    edit "wifi-default"
        set comment "Default configuration for offloading WiFi traffic."
        config entries
            edit 1
                set severity medium high critical 
            next
        end
    next
    edit "all_default"
        set comment "All predefined signatures with default setting."
        config entries
            edit 1
            next
        end
    next
    edit "all_default_pass"
        set comment "All predefined signatures with PASS action."
        config entries
            edit 1
                set action pass
            next
        end
    next
    edit "protect_http_server"
        set comment "Protect against HTTP server-side vulnerabilities."
        config entries
            edit 1
                set location server 
                set protocol HTTP 
            next
        end
    next
    edit "protect_email_server"
        set comment "Protect against email server-side vulnerabilities."
        config entries
            edit 1
                set location server 
                set protocol SMTP POP3 IMAP 
            next
        end
    next
    edit "protect_client"
        set comment "Protect against client-side vulnerabilities."
        config entries
            edit 1
                set location client 
            next
        end
    next
    edit "high_security"
        set comment "Blocks all Critical/High/Medium and some Low severity vulnerabilities"
        set block-malicious-url enable
        config entries
            edit 1
                set severity medium high critical 
                set status enable
                set action block
            next
            edit 2
                set severity low 
            next
        end
    next
end
config firewall shaper traffic-shaper
    edit "high-priority"
        set maximum-bandwidth 1048576
        set per-policy enable
    next
    edit "medium-priority"
        set maximum-bandwidth 1048576
        set priority medium
        set per-policy enable
    next
    edit "low-priority"
        set maximum-bandwidth 1048576
        set priority low
        set per-policy enable
    next
    edit "guarantee-100kbps"
        set guaranteed-bandwidth 100
        set maximum-bandwidth 1048576
        set per-policy enable
    next
    edit "shared-1M-pipe"
        set maximum-bandwidth 1024
    next
end
config web-proxy global
    set proxy-fqdn "default.fqdn"
end
config application list
    edit "default"
        set comment "Monitor all applications."
        config entries
            edit 1
                set action pass
            next
        end
    next
    edit "sniffer-profile"
        set comment "Monitor all applications."
        unset options
        config entries
            edit 1
                set action pass
            next
        end
    next
    edit "wifi-default"
        set comment "Default configuration for offloading WiFi traffic."
        set deep-app-inspection disable
        config entries
            edit 1
                set action pass
                set log disable
            next
        end
    next
    edit "block-high-risk"
        config entries
            edit 1
                set category 2 6
            next
            edit 2
                set action pass
            next
        end
    next
end
config dlp filepattern
    edit 1
        set name "builtin-patterns"
        config entries
            edit "*.bat"
            next
            edit "*.com"
            next
            edit "*.dll"
            next
            edit "*.doc"
            next
            edit "*.exe"
            next
            edit "*.gz"
            next
            edit "*.hta"
            next
            edit "*.ppt"
            next
            edit "*.rar"
            next
            edit "*.scr"
            next
            edit "*.tar"
            next
            edit "*.tgz"
            next
            edit "*.vb?"
            next
            edit "*.wps"
            next
            edit "*.xl?"
            next
            edit "*.zip"
            next
            edit "*.pif"
            next
            edit "*.cpl"
            next
        end
    next
    edit 2
        set name "all_executables"
        config entries
            edit "bat"
                set filter-type type
                set file-type bat
            next
            edit "exe"
                set filter-type type
                set file-type exe
            next
            edit "elf"
                set filter-type type
                set file-type elf
            next
            edit "hta"
                set filter-type type
                set file-type hta
            next
        end
    next
end
config dlp fp-sensitivity
    edit "Private"
    next
    edit "Critical"
    next
    edit "Warning"
    next
end
config dlp sensor
    edit "default"
        set comment "Default sensor."
    next
    edit "sniffer-profile"
        set comment "Log a summary of email and web traffic."
        set flow-based enable
        set summary-proto smtp pop3 imap http-get http-post
    next
    edit "Content_Summary"
        set summary-proto smtp pop3 imap http-get http-post ftp nntp mapi
    next
    edit "Content_Archive"
        set summary-proto smtp pop3 imap http-get http-post ftp nntp mapi
    next
    edit "Large-File"
        config filter
            edit 1
                set name "Large-File-Filter"
                set proto smtp pop3 imap http-get http-post mapi
                set filter-by file-size
                set file-size 5120
                set action log-only
            next
        end
    next
    edit "Credit-Card"
        config filter
            edit 1
                set name "Credit-Card-Filter"
                set severity high
                set proto smtp pop3 imap http-get http-post mapi
                set action log-only
            next
            edit 2
                set name "Credit-Card-Filter"
                set severity high
                set type message
                set proto smtp pop3 imap http-post mapi
                set action log-only
            next
        end
    next
    edit "SSN-Sensor"
        set comment "Match SSN numbers but NOT WebEx invite emails."
        config filter
            edit 1
                set name "SSN-Sensor-Filter"
                set severity high
                set type message
                set proto smtp pop3 imap mapi
                set filter-by regexp
                set regexp "WebEx"
            next
            edit 2
                set name "SSN-Sensor-Filter"
                set severity high
                set type message
                set proto smtp pop3 imap mapi
                set filter-by ssn
                set action log-only
            next
            edit 3
                set name "SSN-Sensor-Filter"
                set severity high
                set proto smtp pop3 imap http-get http-post ftp mapi
                set filter-by ssn
                set action log-only
            next
        end
    next
end
config webfilter ips-urlfilter-setting
end
config webfilter ips-urlfilter-setting6
end
config log threat-weight
    config web
        edit 1
            set category 26
            set level high
        next
        edit 2
            set category 61
            set level high
        next
        edit 3
            set category 86
            set level high
        next
        edit 4
            set category 1
            set level medium
        next
        edit 5
            set category 3
            set level medium
        next
        edit 6
            set category 4
            set level medium
        next
        edit 7
            set category 5
            set level medium
        next
        edit 8
            set category 6
            set level medium
        next
        edit 9
            set category 12
            set level medium
        next
        edit 10
            set category 59
            set level medium
        next
        edit 11
            set category 62
            set level medium
        next
        edit 12
            set category 83
            set level medium
        next
        edit 13
            set category 72
        next
        edit 14
            set category 14
        next
    end
    config application
        edit 1
            set category 2
        next
        edit 2
            set category 6
            set level medium
        next
    end
end
config icap profile
    edit "default"
    next
end
config vpn certificate ca
end
config vpn certificate local
    edit "Fortinet_CA_SSL"
        set password ENC /B1vbJ7cYYhAoN2+dFyIocQ/dS4cD0SR7ib3E9/4cgnE2ShrF4d33T+gjrSD3KwTpsP3IGL+fsNEcG59v/VTNIi9AnKuXjTI3qlGcvgUKngXZiOXkVC7BxNh9WPA6geGzOACOwq03ILfBFU9LLV4TSUWo8/V0wcL4UDCK3F1ii7N1dG2ZRoPz9Zjoi3AWvHq8frN9A==
        set comments "This is the default CA certificate the SSL Inspection will use when generating new server certificates."
        set private-key "-----BEGIN ENCRYPTED PRIVATE KEY-----
MIIFHDBOBgkqhkiG9w0BBQ0wQTApBgkqhkiG9w0BBQwwHAQIyh3yLe0Mb+0CAggA
MAwGCCqGSIb3DQIJBQAwFAYIKoZIhvcNAwcECImR5bFSBppyBIIEyOrcjUUjymqD
iZNITqG0NKG9aVL6e1z00enE8wk7RQ5goaWNJSg/C9j/EUvEVhSQGtNuCwWzkxak
98Ppvg1dEbwmRT7J4yoeql8wqUTVLdASU5CYyHsN4N/2NA+TeM0TW4LODuuVcmAj
v3FTAhn9HM8SBQZxf+knesjmeu7/5JIETxSVsnu0iM+DykfRH3wnn6lDBwcamLjJ
zKkPEhYZNnzYDoiDrCYr8IHFNanJV/4p5qdA9mW3F5PaFAl0/SbFT+MaVms6lzhq
C3N8BGMw+8kwVcJfg6LqbG9wcWg/GEVJjJC442XryEJcLnt2ToICiqzobMWBNgV/
Iz7jeeItJN1flpP/vF3Ndg5l7tQCzzBzKyDWJmVJIPkintoV+l+g+xyXJxzxAS19
sjdjRDKs4DWdVCHsWrZLQj8bQ2uH/kCz5mTlXh9cn5K1GY936OqPW3cGbjeXTrx5
V7MANyTRm17P1m/+1JKrOxuc8JH81EBy/G8eac83AcEK269HXfd6oW2are3695QO
fUlauvq019F97uI8u9BoLf2PDTzcfMTtNsauHmI90+x84N4DpenQ/dj8ksEFwn/W
GRkiUl4SGi9NGAqFDgqxHKraWHdDxWl/2+wJ6Gs7C9tQWAbIFuuOf45dSMx0GTIj
189LYk0uZHYn054zf5JcWEU7rDSBEpIV597OrwdG7/Vijh0GHc15K6Tpuk5mQGv5
T7OAMLraFcWdH1+4u9PkoOpe8IadBVfojvLfv1Buydr6cuO8QlXT/B78cXgnyXmv
RVaPK3ZRagXKWUivnZk5eCA7V87ukZt9NtlA6Qr8gp9zJSoFRgYRKHM190FI1yzb
KCGG77velebrs74fT0XnA/NXSqHQgkyhRsDiBz7l7W/wzVMJJpiUJuLVq+nfsZ8q
wcGnVJOuVu8G9sNRNX6SptisROSAZsiVHc5iqHVdEL73TDVwb/XWcxASVtJL9PIB
RSF9pJC6oY4BMKcBsFobh0638iPmvIrD7JqBMNu+iWayUBDXRrmz27kdAhYg1895
y7c8joBk59qYyim0jd04SkD80A5NeH2VGmWPAKLE9aOQl1iT2LX4R6nmvcWV8XbJ
u9PNouHr6uc/czRGmnlupU3hriEf/ZrdzAZHQcV8fHg+xrS6LLXAOdau8ToRU2CH
oVb3qxr8hVQ8eyuwUkXO029PCLZoceI1Szr7mngZHeqsc/fP0N8vKy6zQBaiYQfp
tsfwihGMS9SjQOc6dFVhELfkb7rTHIjfktmSnMgpnWwyW2rYql+37mTz1bMEt6Ps
TFVOKF1niG8kBciveQIAJBBZqNqFNruVvrKfv444psLlF4uvlpBVD69EqW+JckQH
L82/dQFqJDI5Opy2khwpPSJnI8nC9sZ4xMSVykOigh1o1NOpcDPm//xMpPKqOYt5
JSKxLvZ6iDH84GBYnCZRBYlMMRPjRdjWmK/VK2XYNLYALmQdrnTrYbPoTzvak8Dq
aefV4csGQ9swkcbQUxZKjXvsSZl/LkE+aUt6p75z6WFIaUCMq1HpWABn/W3N4k6Q
1Bqcf9pMoTsKb0H5gHcoFgF3gzIgY9MGAO9t7Y4VVqpuFPItKEPaS8Br2FgAGhSJ
XUgQ03UZx5uDWVQZczaslw==
-----END ENCRYPTED PRIVATE KEY-----"
        set certificate "-----BEGIN CERTIFICATE-----
MIID5jCCAs6gAwIBAgIIBnQnE7FhR8IwDQYJKoZIhvcNAQELBQAwgakxCzAJBgNV
BAYTAlVTMRMwEQYDVQQIDApDYWxpZm9ybmlhMRIwEAYDVQQHDAlTdW5ueXZhbGUx
ETAPBgNVBAoMCEZvcnRpbmV0MR4wHAYDVQQLDBVDZXJ0aWZpY2F0ZSBBdXRob3Jp
dHkxGTAXBgNVBAMMEEZHVDQwRlRLMjAwNTMwMjMxIzAhBgkqhkiG9w0BCQEWFHN1
cHBvcnRAZm9ydGluZXQuY29tMB4XDTIxMDExNDA4MzU0MVoXDTMxMDExNTA4MzU0
MVowgakxCzAJBgNVBAYTAlVTMRMwEQYDVQQIDApDYWxpZm9ybmlhMRIwEAYDVQQH
DAlTdW5ueXZhbGUxETAPBgNVBAoMCEZvcnRpbmV0MR4wHAYDVQQLDBVDZXJ0aWZp
Y2F0ZSBBdXRob3JpdHkxGTAXBgNVBAMMEEZHVDQwRlRLMjAwNTMwMjMxIzAhBgkq
hkiG9w0BCQEWFHN1cHBvcnRAZm9ydGluZXQuY29tMIIBIjANBgkqhkiG9w0BAQEF
AAOCAQ8AMIIBCgKCAQEAvZVmfqvlotaP/jVY71pSP9OBFWTPuUiKTh0aXS4BywYX
i4861cs1eybce8J1aJvUPqz9j+69AfKIwBrThqnswCegUowvgQweZblUvRVaMfZ5
E4FXS8zQOlnvsPmEynCPM+bbR+nbNMwALYBnDolBR3jsegClAmltcpJLgJiIkOGI
OkJruk647bN2WJBWEdEfE8r9wzYW0Mmd1njf974P+AvBJTfLWI1swbYwFKIkIrrn
Gf/+3fMV3jQAjwO7nbO0ou+z/ZtLwZVNKCKl1LR3GnDKK12kXr7apd+UUXjmHWyL
4/oITbs+d6cAEsxiPzQhchYlnce+vP8FDPYxeZqeCQIDAQABoxAwDjAMBgNVHRME
BTADAQH/MA0GCSqGSIb3DQEBCwUAA4IBAQAl+xDxZuzZbDt0iAHogCMQV+pBuKqw
LlbnrEFjurTn1GsUgYVRUS2cmkp8s4xLepo7ajqgR27Tgtn9GZFZIglQprE1+oe8
uybkSgX+faxi6tbInOV3XfdMkidDTBp+ROEYi5FHq9BhHcOeQbDew7ZhvUudSPPQ
EclqgGw3w9Z8yL8rVmxCLX2j7KP1zkuDQ5s7PGqYu9DYtE2UI/WcPMzKa0QDhq0C
1VjivxkH17aDtk5WJMd1qXQxpLjiIrh7PeZxn0KgogpwYcVhep/YVx7i3Xafe+8u
3x9hhp3JvnkeAr4pMOPJgrGOUpJJAAmmKA+O5SKUORETPgJS3DF+x8m/
-----END CERTIFICATE-----"
        set range global
        set source factory
        set last-updated 1597100049
    next
    edit "Fortinet_CA_Untrusted"
        set password ENC o468QvZgA5Mbn9e2A6a1aX1tXYBFF0JAoLzH/wnSXoqk07TZu+SRlr+XDSABf67GcSArPiAlMeSZQN0FGAV68F+aAZj2efMuiF5OpDAX+Cs8tYe97wAh0+7lBB7/GcOeNhPUhmAhTbN/RApLKokaHXED9HW0P6cldE1lKTMxgnTCpLJY2QRGxG3gE3L+y5C9mPcSmA==
        set comments "This is the default CA certificate the SSL Inspection will use when generating new server certificates."
        set private-key "-----BEGIN ENCRYPTED PRIVATE KEY-----
MIIFHDBOBgkqhkiG9w0BBQ0wQTApBgkqhkiG9w0BBQwwHAQIK+GRL8lJCgECAggA
MAwGCCqGSIb3DQIJBQAwFAYIKoZIhvcNAwcECINWGnWBH4PYBIIEyJlzECImfXhK
rMqLAcbcbf0rlWWLHmPg4Q1yUhy+6DCcGqCnYgtsjGCmHMECB0TNrXhu8IyuGB+n
jr6uagznK2+mUreGzvkKpJIa/AF5vp+NG3bzeFST74d+G4YBtFCF7kRMZ+4xuJb8
Glwv1mlqhKsAlqb0tnGNfNlQm5+0y5Q2q6VKF9e36GYss8MHX7lIel19L7ZYqm7u
wUKw5Sqef3CDRc+KeLxHRnG5fzsMSUXOYyE5BQTGc3eQfsz0xkZ0MiKNx3p4cqnG
smLrg1x4287zm5Q59l37Jqd05uTf2KLRHsBFUn8opPSnIX8To9BOEKF1MtiqiSX4
zDOoODNsJ0LL/jM269Q6v9OC4s0/tKver5RTgc+rSc1pDuOfHKkubBJS64cbklSe
BVRntrGJj8mKAzBh4fOYi1vxr1v6DLmGONAdbEYEvde5KitV3sAD87e/UBnf3KAX
Xj1/2qD3ghtOd0YAtIz6GBfevz3K6G2byXrWxWmauAZezyJL2706f4rCOTSipxV4
e1ALenNVoGukkAaiws+eJok4uFuJluhw1L7SjLgo9xrul9jV15EYYbf+s8d9MTqQ
4NMJHckZymQ5SCDsdgFZ+G2vSiLyZ9fI9Dbdy4/ugDs2+Nkghz5zpcinrztQM6sJ
l/DqiAKOfl74tDqXjktEeV5MnDMIOFklIcqnf6ZQUFEuIwN7reBu2TVYnquugRG3
VbbIF+WAW91As51cFh6R1ve103aa3zQ94Fvt8l3aJ05JL6zJyv+a+jpVU49cDVAL
A4DTPmCdEaOLXx6KykM8SWIx/h1etf/9pB234M+d5//gASyIkZH2t6yqlfxf/2vh
fzC456fL8N0YdgJ/xF4crUJE4X2W19zNopfVaBCSBjN1oxJq8170rKiI4hVphVax
uiuU8CDNoZYmtiGYhlEhCLY8QK5ppCNruR9ML10bmBG8O+G3MlCZraHS5jyXcMEn
lFRfehqrlu4wC0MFd8O+jVBqIteN50yIynGVSDPYeujqbSYAWa7b9w2kzuvURU3A
U0IDXxCd89DfFQJNNE4pAD7wtM73s23YB+nMkMOqolEfOAGL4aXOMdzpRubLd+zG
V+N+DRrbElwNkWiOs8WYPNHM+x9M/PhN+/KwJh5utFCZBpHgpkSC5YyLftl95YVl
JbQfzfADfQdlnAc9/l5PVgLKo3LhvPaau/QWAyXLDUucwjkrorKveENDg3oCvZV0
lVnmrQyHS97OqMFBMJ0FInsfTEB+wsZ+tyhpweJ0ajm/+mMgDd4nvuBAhE1iV8R7
2Bac+xVO6zlyySe1hXK3LugaUJl7Qahskli3ewzQ9ioHtMus0m95psPd4f64BD2I
oLwBQnD618J0OE2Fny42+U+zSiozsxEiI0UfwSn5d5h60yO02lhCQccnGCWT+Upj
J4ZVbt4V3na8ogLHs5yExlHprEp5Nuhrgv/cxNEYgEhA8COPMO7filkQR2FYuYpO
hMdhFYs2ayaWYVQrxXmUdElc1/HpKxyYmnamykvpA0XZ1fNJ5BtSRFkJumocQkAw
snB3aUZpFz4HdkdBQ1XFShCWFbIKOniZ3mH2S+0KNRKq90hSImlu3rLag5Fai2OY
7XNMTzPb4s6FbSAQApIQsw==
-----END ENCRYPTED PRIVATE KEY-----"
        set certificate "-----BEGIN CERTIFICATE-----
MIID8DCCAtigAwIBAgIIet7Kxb70BNEwDQYJKoZIhvcNAQELBQAwga4xCzAJBgNV
BAYTAlVTMRMwEQYDVQQIDApDYWxpZm9ybmlhMRIwEAYDVQQHDAlTdW5ueXZhbGUx
ETAPBgNVBAoMCEZvcnRpbmV0MR4wHAYDVQQLDBVDZXJ0aWZpY2F0ZSBBdXRob3Jp
dHkxHjAcBgNVBAMMFUZvcnRpbmV0IFVudHJ1c3RlZCBDQTEjMCEGCSqGSIb3DQEJ
ARYUc3VwcG9ydEBmb3J0aW5ldC5jb20wHhcNMjAwODEwMjI1MzUyWhcNMzAwODEx
MjI1MzUyWjCBrjELMAkGA1UEBhMCVVMxEzARBgNVBAgMCkNhbGlmb3JuaWExEjAQ
BgNVBAcMCVN1bm55dmFsZTERMA8GA1UECgwIRm9ydGluZXQxHjAcBgNVBAsMFUNl
cnRpZmljYXRlIEF1dGhvcml0eTEeMBwGA1UEAwwVRm9ydGluZXQgVW50cnVzdGVk
IENBMSMwIQYJKoZIhvcNAQkBFhRzdXBwb3J0QGZvcnRpbmV0LmNvbTCCASIwDQYJ
KoZIhvcNAQEBBQADggEPADCCAQoCggEBALRAHupfGLWViafq3klJYyLK//roIxZ2
YgaIoRv6GpiP4DEGEarqFjEZfVE1rzgii4clB9lC8WAn75Gmuo8KSQQMWC4vqqD9
04PMetjYifz8XsqAXW1hb1wVtv2xb8nnD2bClj/8i6o37jQMIn2Zd3H59gkIV+L+
Z8RpMi7DQVB3y4ow5imJYs/1yrWD46ynS5dx3/aHUoLCF2DA84gzBwTObUPeqAaf
MgnIrbzBv1/lZ3DsnI5zGtpRv06jMWWYER91iA97JpHNF/sO6wq3x8Jqw49mGc7v
fxkHmJBoarbwOqiwiuqZDaNygTeX5QpXOKw1HSgJHU2dCv0o68u7ej8CAwEAAaMQ
MA4wDAYDVR0TBAUwAwEB/zANBgkqhkiG9w0BAQsFAAOCAQEAMQ9km59WmsTAIUUA
bETxxn01G2y+9A84lBPebiGYVkj60K5f8rezOrFjlll+SPHr8gE4EmXOsIzWCNPK
MDVCch1Er9rp2+0c9AJHi4RmQeAYa2JC2+2idvvrka0+6JuaynElNBLZaVmqI+ov
gqXlBF1qwAnlyAVdCr8JZ7efijefcII85jQhgKaUlJs560LfM43vKJlgFoRy4BI0
1OZzFO/sOXq7q56W7EEqyAZARKrLB3Acrzgkmd8CasQOc5H/RBU68cQQHpZUQZ6b
5UyVnzyYwMNNG+xwaO8uT7Vq2404iRz0X5X/ai433LZItDPhf5rph902mGp/S+tT
aImrHA==
-----END CERTIFICATE-----"
        set range global
        set source factory
        set last-updated 1597100049
    next
    edit "Fortinet_SSL"
        set password ENC K+J7G9iWAEFJkJaXDgl1FzFl+Y/VS4RA0+WqxqrEK4yTU9OmPjA2QLyoHOSRMfbshJ9mfEqCrcQ5GANCvET4UqTcIDfmZuE3b4HwmsL1hPkz7arZMXn4I+uGLloueCWMUqRZspaooH0IrxNDI21E5Lw6RPv/KDQMqVh6H4SlnxKQoNvn6N1GOMy+OECO5p6xsokh+A==
        set comments "This certificate is embedded in the hardware at the factory and is unique to this unit. "
        set private-key "-----BEGIN ENCRYPTED PRIVATE KEY-----
MIIFHDBOBgkqhkiG9w0BBQ0wQTApBgkqhkiG9w0BBQwwHAQIy5C75e0zowQCAggA
MAwGCCqGSIb3DQIJBQAwFAYIKoZIhvcNAwcECDrWR09qbYq2BIIEyF4pV6hS4Ps9
iE8VHUf6vDW6KiJ50GqCMJLB31txAo9lVi4oJNrRqKZhzRSV0e9AEeOoZ91Rghf2
56Pa1BL+pwNIrQUPRcngm7wscbF7/0eh0dIetv9lrCerimo+7NSastVN+RdJ9KYq
8frrswIfMO8BrN4VlCA818Bvj9rDoEKvtRxmHe0FhJ/shJAl7ph0mtRu8vEYNE6T
CqIrvCj8qd3d/5hu7eh+cp9j9PDHVs7fj2DkaPlnDquaxjv1teheki7EJ4F7N50D
vAdu8xJQXPHDI3QabWwyCCLDlnh1/otAnnABlQQXaTXMJChCeLLm4QX7xpj97R7i
1uwjf/8VUQVY1h50vad8+DtNkWPToTW9yxDNU6QfcpEtySla1zKzH3xrKpu7FObu
Nc785L6Pv3+hW8nExooK6wlfhOUHKJKW+dHvDFMjzQC/0ukV7ygBZKdgYgA7IgKH
/TsQO2+bfC6YU0vpGs4/QO8fIWaiv5J6iTkMxUQ3J4kooRr7POiqjGzGkDQnJcNd
RaBySV6UC5+G+nVwyBNvtjQbBPVEZVlmO6sfxQ6jQ3LYklC6JZto6TpZAStAt5gh
qfpqVZZtfA5wCiaSesmPCzgt5OP1pXKwrRVrJEFPv8vzS3gTeTa1nrWS19F+jTij
8Qx86K+2ST7hA2G2NSFgBCyEKFrRNv6j/j9sx4QZGTXXRPVQjjiRHQDzVaKPJjiD
PAopOVgWBwSnHfGBqyeMBy9XfKIotDOOnog2Wpjy/YhW4uyUl3F1wdLRQOCPTuwM
Ka+1L6bD+aVQsWqyCgTf1+ykaEoRHML4WSM5LBrVtydlX7jwQTQu1n7C/+8KLTB4
bWsV5ZFjuxtBRqB2w/7h6uCLHiMStBknDqHZbpnREYg+D7Wp9EiA8SoUi/hn2E16
JVwoEbuLvM2fK2gkNLFS1VnCImoavuMqIK0JHEC0ONgR0zdtaSszUZBqu2qYAOtk
DhEuAhIotQjt7mSHrLC26InBErVt8KoGRX5MnUkze+KvrxuE5nOYCQxubYuEQ41E
uHDoteamOhU4GY656GaFFOfxaiUQ1b+b6kJOvLjHiHHDAOwZvhodf5S9bZpc+VDx
HLrV29dBYNQnUQdt2mq/buDoiWJJwnNhvusI72Kitmn8+kGMzlAlJJigDjw+AQlY
C7O9VD9jMV5pbDDIPaigYVMieQAn56TVfxJWCxxukj0BTyNh+071G8aDP8b7vBhc
s3PZcIOrlenp3hkkjLZJRmZQIsd8CYY7EMwZGbxhXZSNoxXAHft+wIg9VdgjMRox
1o0FT6KX6XREmYzDcnbgOBw9R+KIO5gNuwJZQ+Na7kDxmbwCMGb1yT+8MOBwuHsZ
dzl98tdLzInUiaxn6cq9Weq6ZUB54LlYe9jM4oQAjrrqIrq2MaJBIv83H2ZHB5yA
Tah320NmoCagKRRRDj0E+mFIFt46rnM95bbUimIFBBYg/Zl8tqDYXVAydL8PtG6e
/WpprQxVLW9pj5xPrTxOY6c6ENeRezrDO1TPLAinJ/zA5BZZP/rDuj9aY5s7VLyQ
gLjGYTyHFhLcT8GQ/AWSmqOBvenFu6jTz6hHR1rwuP6u9mcI9MqWI8XnYcAdEBBs
D5vd5vHtDRmEgso01xIqAw==
-----END ENCRYPTED PRIVATE KEY-----"
        set certificate "-----BEGIN CERTIFICATE-----
MIIDyzCCArOgAwIBAgIIWGj5oQ/cfjQwDQYJKoZIhvcNAQELBQAwgZ0xCzAJBgNV
BAYTAlVTMRMwEQYDVQQIDApDYWxpZm9ybmlhMRIwEAYDVQQHDAlTdW5ueXZhbGUx
ETAPBgNVBAoMCEZvcnRpbmV0MRIwEAYDVQQLDAlGb3J0aUdhdGUxGTAXBgNVBAMM
EEZHVDQwRlRLMjAwNTMwMjMxIzAhBgkqhkiG9w0BCQEWFHN1cHBvcnRAZm9ydGlu
ZXQuY29tMB4XDTIxMDExNDA4MzU0MloXDTMxMDExNTA4MzU0MlowgZ0xCzAJBgNV
BAYTAlVTMRMwEQYDVQQIDApDYWxpZm9ybmlhMRIwEAYDVQQHDAlTdW5ueXZhbGUx
ETAPBgNVBAoMCEZvcnRpbmV0MRIwEAYDVQQLDAlGb3J0aUdhdGUxGTAXBgNVBAMM
EEZHVDQwRlRLMjAwNTMwMjMxIzAhBgkqhkiG9w0BCQEWFHN1cHBvcnRAZm9ydGlu
ZXQuY29tMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAqofnqMJAumg+
94mtkhWL0creDJk1BFzy/oupAun4eUrf4kgzCT2JplLS7tPEck+QYSj9bAGwjAkd
0BtBbLwe7/tDtDO+z88URYVxnn0yW23c2mSBmiy9Sd5Y8RMe7PJEhZy/MGmNfoi6
P0GUIYmkCpKFC8KN2OVG9JSrZv/rtg/GNvNvBUYYW/5vRihlkqh/+MRLcuoNWXLO
42u2Gb8hXiSfvPBUCsYg/mbeG2ukr/oVZhM0Ru6wqGGErJ9LTfWKc0nguBPLxY0j
vh5vw2ylvRD2PsdQH8DzyzrlfhwIQWdEkBb8Jb876S38BdRMO12lgk8AeAvzcj3n
cS2nLaJ15QIDAQABow0wCzAJBgNVHRMEAjAAMA0GCSqGSIb3DQEBCwUAA4IBAQBO
T5wsEWQc/+gM6O45chDKZQoTkEP2vQ12E3efLDreh6wV3C7R+jZ4PNZcGp3yHUO1
8tG+onhwVhSZi6X1qXAtySVvnLDQtPVb4O62SN6K8lBnVsE7vFqB1k/uHm+eSQJh
hYw/u12pl9gONLe5A3juuw75pKlKITnKiAnccVdFIFeVrpW0/C4t1zbUVOwd1h+m
HkKB/Kq14k5nKlfAWoIYGrW7ZZddKpuwax2eFp25lA3PlQH0i50CsocqD64ODtfm
n+uhoF4TL0yW5sBbtemcp9thNlYFjGqH5HKE3Jwd7FwvZFmdeh3SGjQUzgz+bleZ
+gHdgC5oIik/XESZcndm
-----END CERTIFICATE-----"
        set range global
        set source factory
        set last-updated 1597100049
    next
    edit "Fortinet_SSL_RSA1024"
        set password ENC zDU6kxKSYFLy2mffkG2xIGBgRItChnkPxMxMGcMjXml64Z2LXzxGv4LCTLZlyLMBCvqsfrO4QxrwhKP3E62x2a7Z7saJ/Ysitm1Mz6j3aBjwUdgG9OlQLnXi5YbEYfvyBupKFuxHvZqM4gX4nf/2tsE/BWm7NV5Jl1qAlhFSL5ZpERtOsC5DN8cBAtPldHVztmYwHw==
        set comments "This certificate is embedded in the hardware at the factory and is unique to this unit. "
        set private-key "-----BEGIN ENCRYPTED PRIVATE KEY-----
MIIC1DBOBgkqhkiG9w0BBQ0wQTApBgkqhkiG9w0BBQwwHAQIDhrfNaHW9eUCAggA
MAwGCCqGSIb3DQIJBQAwFAYIKoZIhvcNAwcECFsJUphtenXABIICgIwUi2O4NEVk
xHYIzj+IRiBjLa/FpXcA4EbIwH1k8kfrlARxPLeYEUGtTmF53Xx0ENEt2cLdy6Sw
JBtdi9jUrxQucT0rRLmLspMrcRYBrjQ4LMk9GdoFzLUBbyyNtMdaaoAtxf3/70mC
mGEfUEzHGmBxu1Z7nnCwBtvFAfiv2p0wdyTA3BYAEvFJTHz6KPKNglYs/xVyRhX+
OZu1/Vxh2lrxMkYNhwZphiVwwOcNWrj2KsVCahngO18cxm2cjxqIBURyByg00oAA
8xOd3W1Mi4t/fYt4Vqr98MB6b7XCZRYrcuNsB9Yuz3HMleVsu/j+gasoDtn7dpEF
ztZu5qa+QJtMJ/ZJKuMAzxlzOY0kULQFj3LSmOwpQtwroyjrN1CgdTTQW8c7TQAG
A+d1F+b9hdHJZNh1z57HF5PN3cJboSLvbMUytDUtLMmKQ/sME6Gb3q5TvxfneF/4
zZjJeBTY0Upxo3SPZT5JBrdwqfR8Jn7vKOAC+Bq4bzm+e/7zWEu26OsOW4mBUisJ
wyW92gLaQPMTvfe4rGMpgVj9Cizm6xpLclUcKEWW/O9PGeR1V5SHAwnGwmTwiIX9
EabhPCk7wPJUdscKtreZ05HbvAliXoJnVWf60iQroWzHX3M02x6Y+osTTTCvTzv1
IweYHAatJ4n+fctrxeh1ZcRhI5uxg6snvZR0NDiXs06fc3Tt6H/vVe0Vnzbi7nFO
0MqR2QKxnpM0pqN1YCmuAFywRk0FGpfEtKApkNRJldE9EUbaN208AEI09iC2Ebnc
/NvkPXbPgysiVrigtrLTR0CHjiZ0U4o9o1vZxGAVXZko5Odt2XhK9SOlRMhIIdTo
KfkXeMAOG/4=
-----END ENCRYPTED PRIVATE KEY-----"
        set certificate "-----BEGIN CERTIFICATE-----
MIICxjCCAi+gAwIBAgIIYHUixvcLaMMwDQYJKoZIhvcNAQELBQAwgZ0xCzAJBgNV
BAYTAlVTMRMwEQYDVQQIDApDYWxpZm9ybmlhMRIwEAYDVQQHDAlTdW5ueXZhbGUx
ETAPBgNVBAoMCEZvcnRpbmV0MRIwEAYDVQQLDAlGb3J0aUdhdGUxGTAXBgNVBAMM
EEZHVDQwRlRLMjAwNTMwMjMxIzAhBgkqhkiG9w0BCQEWFHN1cHBvcnRAZm9ydGlu
ZXQuY29tMB4XDTIxMDExNDA4MzUwMloXDTMxMDExNTA4MzUwMlowgZ0xCzAJBgNV
BAYTAlVTMRMwEQYDVQQIDApDYWxpZm9ybmlhMRIwEAYDVQQHDAlTdW5ueXZhbGUx
ETAPBgNVBAoMCEZvcnRpbmV0MRIwEAYDVQQLDAlGb3J0aUdhdGUxGTAXBgNVBAMM
EEZHVDQwRlRLMjAwNTMwMjMxIzAhBgkqhkiG9w0BCQEWFHN1cHBvcnRAZm9ydGlu
ZXQuY29tMIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDsm3NyxWqYd4CXe7od
zBCbJNRs//LS2FiIWZ8u2I80WXdx38RtWjmS3Rb56FFj1dd15S8ummqE1a60M2t5
Sx0VJHQ2iJMTHQBQgTYkyJtp2VCITRaMVzEcnx8SU9fhoP+Mqt3QXhlnKNjHEbms
bwXrUwmbAQx9NL+6AWkPPNxSfQIDAQABow0wCzAJBgNVHRMEAjAAMA0GCSqGSIb3
DQEBCwUAA4GBAEePoGybznjmSzCWw8j/vJ7QKMMjv/8vjmz5urzvXcAAYKDmOohx
ihZFwT8r5S6DpYSk3G2UE6NNZQLKWW1k+S5Liwy7tl17IT8fJ0tvvttGCs5CBuBW
kPIayCH4x0Mzf/Aok5EdD+BVoxE/wJSSiPNldHxU3wI0STRu4uJVJfIe
-----END CERTIFICATE-----"
        set range global
        set source factory
        set last-updated 1597100049
    next
    edit "Fortinet_SSL_RSA2048"
        set password ENC YDLo9RGNkDpDb7L0BF52AUQuLUP4uOJO8af/bgOxODCY7LQ4H7YGi/8kQ+v+0XLDtyFmuS+fP9B2z5h2q+cPRDoFP6cPBJQW45ynNYQM7d+YqBpbTGbnquZVtz4Uewfb1R8FF3815ljM+Ay/Qn4CVeaCyBfPJDLlvcUnvA3tF5HNiapQNjq4xXZQNIpGoHncfBCpRA==
        set comments "This certificate is embedded in the hardware at the factory and is unique to this unit. "
        set private-key "-----BEGIN ENCRYPTED PRIVATE KEY-----
MIIFHDBOBgkqhkiG9w0BBQ0wQTApBgkqhkiG9w0BBQwwHAQIncyXNRo1bHsCAggA
MAwGCCqGSIb3DQIJBQAwFAYIKoZIhvcNAwcECLxgouE8ZdDbBIIEyJAsCDkC1uyJ
FMuTvrVKhCmJd5oQRZxQVR1UhpKWhXFO6F7mIReiHHxt4Yu81hiSsrB0aoHBm7+Z
KFzENAolJZciKY1yjdOUo35A1ScAXyNF5n6qtJfl0/fEGteaP+GOpufdm4wMw2ex
W0/ImY2Mb39kUq9XQ+lM8ilAPvuU+hjAkK7LnN28SMS5Y4mdPerMM/6h6fPqmmJP
4Yq866E3LxME3CMqfu6EIYj+uZtG7/0L1fvEKWS4h5hlZfG4KwoIiAGbgIZL/R3N
jKdJc4GWF0aqYxL2VfUXuhaWRa3IV4fBc/JH1/ZPGwvo7KVamXrSHbR0oeGAURpU
sQi948Sg9jXbUBocg1plVkUiT79WjENHI29oXJGsUg8khotAFeuk0yLvMPVJ+rtN
165gAUAOkMu3akn5Ya0qgAnxoIkrOJJaG/yQQlG3xv33CYJrksHvcyZh4CotSpso
EXDwlXkHsYuKzfvGB/Ugj8BZVdOeijlRsS6zjfJqzCYV6ndK9mCOSO9hfeaOfieF
Z51VnC1c+f5ZBro84pYVe5+xqtGMkRvAsQkSfOliqhS69fLMTlWADmYiy4vWoRDi
UyqKDVwKPqoRH1c9NYO6dh/UQJ2H7lgS+6ly/NwzedbC/c4xO/ITznKVwNo+zRfM
8R/pwa/fi9rREljnwUk2DOJWkt/N5lLLzunxSSltylOnlkmQnelOfkIO3bWrCdvg
3ai1lhkOscG66P3sMunbpvuJ5EtttLVia6YWmX1Qmkn3xlbTtnWcT2vY6A1c12az
WfEmbcjrw9yiQ5epZyXuasXM2ukPJrVubzTlkHEQ2dyo5P6tT14o31GFhPWCuJeL
tCD9PwqA3CkiGdDcq0+B3vKCxWclAMrfzOxDt7bdHzEVN6cCcwx55qxgaBRWUty5
xXgudhmvR9iMCh3C8aEre91A1sv54EDe/MgH2UK5zS1RGUpxZz0kFVW/INTvnhgw
ze1iQj2rRcrEuhL0qztJNZBuh3+tPvy37hOhWxEducRsWxgN1KTQ1khG0eU5VoOE
9dt3KTbgLGk1VF81I9VSH2KkwuuepsUyx8fKz8Pw6jgk0yh/XziQ0TmcJMGLOYdG
MRkvsrz4xIKSyA6XN+F2dmxj3ZGjN4WcEFyf7eqaCZnMIl6nCi5MDmnSRFweirhq
WWsbHHCmmPSPJMPbkF4qECBEwQUXv/ckMq78dNBQZkHW4Xrc4ABXauS0n/UT41H4
DQLk28UJsYliU0f+CYl+t8aUsGTwZvxcdMA/fhNu1t9m0xu0dMJXF2gGrpCcooRM
dsJryRc5o56lgOysEUAO5RE59x1jfT4J8ikeDrdwIPGxhrT+aQzoVq61iMfVI2hQ
6IpvYIoUBL06+ZLWAMpUhALXdkcvHMBDzVKykWWDNMp3FB8rhC9kcCBBrD417oQO
Blt2xoByWVbjPKR2CybTP2XZA4gM1Zo5/SNiHgEqtyOmSNcnLsb5CzN01EQQ+H0R
mJonDoC5CxDZuPsImGSpyWwmp3usMF6ScvEuvFjZE0SNYDt2MJHBKsNfRUvhYF/F
p7i8TpZiOBdqM9snS2EoLIiLLl2j9DWak0OMo3oIM7Tm0E8/4ahOQCfuvuFHMowP
Qdyr8X/cGP39AE5J+67oxg==
-----END ENCRYPTED PRIVATE KEY-----"
        set certificate "-----BEGIN CERTIFICATE-----
MIIDyzCCArOgAwIBAgIIWAj62Hq7kPAwDQYJKoZIhvcNAQELBQAwgZ0xCzAJBgNV
BAYTAlVTMRMwEQYDVQQIDApDYWxpZm9ybmlhMRIwEAYDVQQHDAlTdW5ueXZhbGUx
ETAPBgNVBAoMCEZvcnRpbmV0MRIwEAYDVQQLDAlGb3J0aUdhdGUxGTAXBgNVBAMM
EEZHVDQwRlRLMjAwNTMwMjMxIzAhBgkqhkiG9w0BCQEWFHN1cHBvcnRAZm9ydGlu
ZXQuY29tMB4XDTIxMDExNDA4MzUwM1oXDTMxMDExNTA4MzUwM1owgZ0xCzAJBgNV
BAYTAlVTMRMwEQYDVQQIDApDYWxpZm9ybmlhMRIwEAYDVQQHDAlTdW5ueXZhbGUx
ETAPBgNVBAoMCEZvcnRpbmV0MRIwEAYDVQQLDAlGb3J0aUdhdGUxGTAXBgNVBAMM
EEZHVDQwRlRLMjAwNTMwMjMxIzAhBgkqhkiG9w0BCQEWFHN1cHBvcnRAZm9ydGlu
ZXQuY29tMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAxhcVTdmsZ2cj
+63Poj2nCoDpLwymvOpuiqpzWH5gENzoC969z7W5Qeu9De4yT1BDHUEMK5L4asGo
hBvhtSjIj7e0ZXZww81ME9C7p2AbDl5Bzhzsaq8Ktbe1f4hH9hNbjU+P7vMreOst
jzNbeu5hYNaQ7Lob+n1i4pmLp24sSdxgc20iRInQAK+26YOcqqSvMlPjQhBflWZA
oDVuDYLn2zhTW+Ls+Sc7vP+puLyEPmZSSKcvdQpNI6ycs9HcrHRIXm/93bALZX0K
mM6m44RAS/4ocbFISIeHxTDQzyjiFDAg9zuxw9UjDvjFVK8x0DSPY4qUFOcKDNCt
s3Nc2fLkiQIDAQABow0wCzAJBgNVHRMEAjAAMA0GCSqGSIb3DQEBCwUAA4IBAQCO
a7OUurX9pObsMJQblyfbajLX7hFg2dQYnDR1E6VEUj04fEDufadov9Su4kmYjpeX
37S0zw4qnxA6cCjdwDIlGOsNChTk4v2Te7+VORDnCfm/hvUe4u8prMcbZp6ggfYz
GKlk8MMAGv+hICMDM35D3XvFsb/k4zKkQ8jB+scTLK25Bcw6fXjGH5pY6C3zB+rl
eVRvbv27jq/EUPdelLapCl0jAKuppxQC4bdGADpppXQot2O6uCMj89mwFzwjz30u
FFP4qhqZPwPSh0bEf9B/r4LKkLHlDH2u7QoIXL2H2MOQ5HwgSXVjnS0unVATM6P2
He84LsOUTlPClKUmkZVf
-----END CERTIFICATE-----"
        set range global
        set source factory
        set last-updated 1597100049
    next
    edit "Fortinet_SSL_DSA1024"
        set password ENC NVZMwKsumQqS+uhTY29XjncUV9fgOUSDgFUhkGYkq0oPxAwsp3utzCMgZnyLC0Wf17ZEfssvlHlrqwTIjwEGRTzMyF5vYt71weWhKR9xwemqoEsVrOh2U55mNR2DMEkl0BaOKjgKbkhFBwjQEBE4vdszOZrCRQypOYs+PtR1fyZnnDu0eDZvo8kB9Y81zf399bxOyw==
        set comments "This certificate is embedded in the hardware at the factory and is unique to this unit. "
        set private-key "-----BEGIN ENCRYPTED PRIVATE KEY-----
MIIBpDBOBgkqhkiG9w0BBQ0wQTApBgkqhkiG9w0BBQwwHAQItBJF5ExfU3ICAggA
MAwGCCqGSIb3DQIJBQAwFAYIKoZIhvcNAwcECJviS05I2n/CBIIBUDHRHDHlVRgu
Gje2FiSlFQssqGaig8aT2zjnQwSMrm/0kNroqOaBpTtrTVTfIMTxoyksmOR0FYoH
ihYPwrueQdM6CtSv4tDyOakqMfuHZGVYisyv72m/PTsEj92/SJ5CACps1gekBqUL
5CokfBcdORYxVv4KzVe3ncsxJTv1w/XLAPIarGvm7nnm/WNSbT5vh8VgXcTW82CD
TrwH6lSjWCBBD1p8emcpFR4eX61BIGIzrMCTiJxR1YAIUNXlVKy+imPuSyUeCGco
HtzJna+9FCHlobaq/+x8Z2IFSCTeSV0fBuZe12GpJy9VjtPe8dnI842SA9K5QMc/
ByYg0GWdlIwM3D5kXN11DpQRSF6iFp/VC9YkMXShjGplY2hSWd6459yZWXtDIFxk
EMhOd/fg/Tp3xkexY5jndjNGZwJaeQWnGtwJWJNM17etOV1kNsCyHg==
-----END ENCRYPTED PRIVATE KEY-----"
        set certificate "-----BEGIN CERTIFICATE-----
MIIDijCCA0egAwIBAgIIW+0mSO7oIGIwCwYJYIZIAWUDBAMCMIGdMQswCQYDVQQG
EwJVUzETMBEGA1UECAwKQ2FsaWZvcm5pYTESMBAGA1UEBwwJU3Vubnl2YWxlMREw
DwYDVQQKDAhGb3J0aW5ldDESMBAGA1UECwwJRm9ydGlHYXRlMRkwFwYDVQQDDBBG
R1Q0MEZUSzIwMDUzMDIzMSMwIQYJKoZIhvcNAQkBFhRzdXBwb3J0QGZvcnRpbmV0
LmNvbTAeFw0yMTAxMTQwODM1MDNaFw0zMTAxMTUwODM1MDNaMIGdMQswCQYDVQQG
EwJVUzETMBEGA1UECAwKQ2FsaWZvcm5pYTESMBAGA1UEBwwJU3Vubnl2YWxlMREw
DwYDVQQKDAhGb3J0aW5ldDESMBAGA1UECwwJRm9ydGlHYXRlMRkwFwYDVQQDDBBG
R1Q0MEZUSzIwMDUzMDIzMSMwIQYJKoZIhvcNAQkBFhRzdXBwb3J0QGZvcnRpbmV0
LmNvbTCCAbgwggEsBgcqhkjOOAQBMIIBHwKBgQCPhEVqsgiPPdi4MI4yKkULwwmR
zUBVfdWdjV2QtqRpuc72IAd3ZE//QZ0tLq7PGg8DFdWx/m4GSE8z4qxhZJkDWRCe
MrJvJsMce+lngS9g1hVvYaCL+nq4uHxR8vhs8QL5UyMMDEmngql1hOeyBeq5FMZM
7PwCc6gOegceI1lZpQIVAN8fTsoWw8Oiw7h4wQeZM7VNV6GDAoGBAIzBAU48bvmh
veNdVuyG3jyMQa50g5l0puHdUtiLtcf8T0SzFaMBl+gtrE8Acy6GTiZoVYPmazGP
jdmy3ItZ3SUAk7Qowsn3TRmqvYoh+0sRDmjLBxd8g1Njc537wtKB5gpts5Pkr9Gk
oQxV/BDz3wjTOtOqnj755SvqUEpLuDlcA4GFAAKBgQCO4R8jSDBDSJg/+CU3rPWv
GtlgY96q0MT3FDsC0tPomQ5jvjxU96JpwItFn9u3p9TG5XcOfbhUEMRE4u/oRkn2
GuXrNRTS0PNniJIFDUGas0a2T1Rn5WjkqP80HST4bWLdmvdoQu1M/A+i29LLCqC5
9aBheb5ueOItmnyuhdJzkKMNMAswCQYDVR0TBAIwADALBglghkgBZQMEAwIDMAAw
LQIUNOjrFH7oXsEoBiHxYATCmCsLDG0CFQDUSkwXtvHr67Mk3MGongNmLZwHbA==
-----END CERTIFICATE-----"
        set range global
        set source factory
        set last-updated 1597100049
    next
    edit "Fortinet_SSL_DSA2048"
        set password ENC 45EPMt+DoDMbwUSD8ku2+mXakLu+MHaFIDb8UfK4VzCJ4WFNAixODTrbLYam3nbH+qO2P6UYBwnLk8w60FjEX/cXanL7TGtyX6fPBcNG/8pMat9/ZcbO8N2cr5OuFu4rgoowBfUrdv7Oid2WBOpWQl3fukEX1c5aHWoBxVozt7VvqBV4y3znSZNPu6xbZyt9F6cHGw==
        set comments "This certificate is embedded in the hardware at the factory and is unique to this unit. "
        set private-key "-----BEGIN ENCRYPTED PRIVATE KEY-----
MIICxDBOBgkqhkiG9w0BBQ0wQTApBgkqhkiG9w0BBQwwHAQIAZeiGdA6F9gCAggA
MAwGCCqGSIb3DQIJBQAwFAYIKoZIhvcNAwcECLkLMqx0kiI/BIICcGWbOA4r4Zih
9pT9SYKkPM3L2jk5aENcEs3/GjgWVbtdTIL3dgs0ks1r22FQob1+3VtjBUUGl6w0
1QAa+Iktxfvz11jj1HwM1mkcSVsCiFy3PFxV5jX3ZUcQhAlZf3nAVhu3gW+LZEku
huTaFdu0Q+1iUmOgS5PPIBBT3CJSsXlsUviZjGKCokci52wm7GULdWkxck42OQc5
tVTUIkjcPOvVPeNk35dm35Fy3UnuBwW0TxVWrLlDmYhfdFCf4JkvhgZKdqLpgNvF
UpCwdegxle//yzqIMR0BLUCWrnogPVvzQAa/WWuJ7SjFI5mDcd3E0HKMReA+O6f4
oKYN/ANXXeTlR3S/XGp4r3VYXmPS3dNMO9/E5GB8pTIV6TufPRx7iIv59nQqCvRK
ZP0QsLSPKI/EbS2jAAkllr9yaTTsfhTAsBL7eRqgX+d0rrmHwjsv6UtbUDhVQC6r
pyl5LehDLF3iPXFOOsRpEl6AQX8xKltFdkZiPZ+bqKR8lcwQ3hVmrJYH2C/LIGVp
g+bolPy+uIap3rXoVCyqjLpCe/8JqN3pi8MdxBSBjlL8RXLVkwZsWGwTjIXitKDA
ejXJ4Cyzme8nKYs/F8dxX0pbVxw6Vhct/TqHVcVt/bTuCVPMkQNsJa9cUcBGqjZ6
Hz3NzvA7u37IxHTnHKo044z9nqAsUoBFpFkJNdonQJsbYN/djExofSdO2cSDJQBu
xd+T+cfrIIDRlmxKIyZPNKbpEFAWzwaJBcAJcXVHWM2R/sm+YahYkhtdYjoniM3M
JwhrsHH4r5tahcpKyTWN/zkLsOosiqmmQI8JdnyVxQCysywzBGQCtg==
-----END ENCRYPTED PRIVATE KEY-----"
        set certificate "-----BEGIN CERTIFICATE-----
MIIFLzCCBNWgAwIBAgIITgLc4UAPsWQwCwYJYIZIAWUDBAMCMIGdMQswCQYDVQQG
EwJVUzETMBEGA1UECAwKQ2FsaWZvcm5pYTESMBAGA1UEBwwJU3Vubnl2YWxlMREw
DwYDVQQKDAhGb3J0aW5ldDESMBAGA1UECwwJRm9ydGlHYXRlMRkwFwYDVQQDDBBG
R1Q0MEZUSzIwMDUzMDIzMSMwIQYJKoZIhvcNAQkBFhRzdXBwb3J0QGZvcnRpbmV0
LmNvbTAeFw0yMTAxMTQwODM1MDdaFw0zMTAxMTUwODM1MDdaMIGdMQswCQYDVQQG
EwJVUzETMBEGA1UECAwKQ2FsaWZvcm5pYTESMBAGA1UEBwwJU3Vubnl2YWxlMREw
DwYDVQQKDAhGb3J0aW5ldDESMBAGA1UECwwJRm9ydGlHYXRlMRkwFwYDVQQDDBBG
R1Q0MEZUSzIwMDUzMDIzMSMwIQYJKoZIhvcNAQkBFhRzdXBwb3J0QGZvcnRpbmV0
LmNvbTCCA0YwggI5BgcqhkjOOAQBMIICLAKCAQEA0WGKErnwB+LlCEZtAu3Fy/St
nuopngdaaSTDPVXuVyL4QTl9rUnefURcotsO8yujFtyXxBEyKebR5L0CCGVuPWKk
qDQ7uCE1ngyb1pWSDrC917VwU5t+ocAPgmcc7Q0/dhCoXvodFBqfhNR1OQiy60aC
NpVrAOx3UQm6tV6oztzABj7/HmUO9FP6aVAqCP/wtXVcxMO36jKY5TJVHwKvL7Ty
UQVg8vdhOP/NL9iHdGW2C7w9+45Wu3cl6UZOMEO5DVlEylEUx4uY2mhFXsQ23k9b
Q2rOqkSqoedHjrarPQtILxyYyzxUQCPKU0wCvDm3KOmB9Li+3Ki3fxJminmu8QIh
ANVO0tWi160XsIrFmbouQZ0bmy3Vf9J8L9JL9lL9Pb2zAoIBAGkbVWJfe0ZkmQ5v
/fO36nqGZkDuF/HNtJ3kUaw5Cyihp1JY31QzBadBQILYIxvoP2e10ZnEcn9U2FY0
iMwK33zyr4JUTBiNmEM4xZrVwfWvgrhwZvN7zgyNH2iPQ6eVRu9ZR5vwsUoe2SmU
D5tvZFf6HRx8aYDR0YTyYEB6IXESAfkt8kEIxIjudPiuhL8GcBFvUNl8p9C7bCEK
BjcT1SwPoYPVIBNXTaVgdemzgHgn4lzb42UpLkQ3D2z9+mvi33Xtv6qQXfZYuTdc
JbyC7KugFlDB88Ze7dBwVSqqP/s+UCkePp5ouJlFMqvTiGSJsXMY3R1APeK0Se62
MLIWyAIDggEFAAKCAQBqR3mVtA3vkKpKpWidccv+STHGoeyHVnlnUAuqE8wLEjuK
fwjhlW9M/0zCROOsEYlOuUFFQ7e5gK+kZCmfmYUZ2xVw7i+4rqOw/1tHBxo/4al5
nYFvEW7E7MtVDpO/n4TxcErC35MXBtJ9EMgs3P9qQH5swf/6P94cSZ2WGQLl5XCI
7RUpkW5e9qH8VnXviL6hYugpEE2niSLzyhhDr6sCns8fShE/9ty/nBpB/NDMS7mw
TaAsKlPQMitHSoUPEFbrUfUn+B2ayrZSqQk6OGLoI4BATjhcanDmbMTMOcBw8lyF
be2BXdBD65vSrZIqIfrQN23m9bE8FfIkStAxVYtRow0wCzAJBgNVHRMEAjAAMAsG
CWCGSAFlAwQDAgNHADBEAiAS7kscgTQk7XPMb1RWtDgVreDSwoXashhXodWRC15X
GAIgWaRwM9j8ZY929PsLCDLphUtSkXtbKqBUTKyVNAuFcY0=
-----END CERTIFICATE-----"
        set range global
        set source factory
        set last-updated 1597100049
    next
    edit "Fortinet_SSL_ECDSA256"
        set password ENC JQSgh5UxzdQfER+WcMw1jc0rfeEsz3Zywcy7wTJGZagioOcnqiGH0dzhkizOwjiaNQdSLsI7ogt2XYxOUG5Xx7y0eWvtufReigSIktRMBOOVRf5v5fNpsXiu4CJAWXYKA0M9PzP+lMMYyDhEsePQ0ZO1xyTkQmJD7NjB9fGzEc8JxWHBnYFN55i/Nhf2Jq8bPC5bOw==
        set comments "This certificate is embedded in the hardware at the factory and is unique to this unit. "
        set private-key "-----BEGIN ENCRYPTED PRIVATE KEY-----
MIHjME4GCSqGSIb3DQEFDTBBMCkGCSqGSIb3DQEFDDAcBAjr5QV+2Uk/IAICCAAw
DAYIKoZIhvcNAgkFADAUBggqhkiG9w0DBwQIWxu9hYojskkEgZAR+RejBhrTivan
vIKjCs2wX2EvV9gBKiVfnY4DsCXsfntYfHojTVwwUaCtnCYXSMrmvwl+bzR6INiw
kv0T+5fmHUkTwxh8l1BgpTCtzpGyR7R9UoDl0uuKPJsOeS2ga2+iyizGk/S5xJnI
XsK5nuSAEvR0oGxTestKeaNl0n4uNZiydFQ+DwxfN61UxLgkQaA=
-----END ENCRYPTED PRIVATE KEY-----"
        set certificate "-----BEGIN CERTIFICATE-----
MIICPjCCAeWgAwIBAgIIM8sIOWcCg/AwCgYIKoZIzj0EAwIwgZ0xCzAJBgNVBAYT
AlVTMRMwEQYDVQQIDApDYWxpZm9ybmlhMRIwEAYDVQQHDAlTdW5ueXZhbGUxETAP
BgNVBAoMCEZvcnRpbmV0MRIwEAYDVQQLDAlGb3J0aUdhdGUxGTAXBgNVBAMMEEZH
VDQwRlRLMjAwNTMwMjMxIzAhBgkqhkiG9w0BCQEWFHN1cHBvcnRAZm9ydGluZXQu
Y29tMB4XDTIxMDExNDA4MzUwN1oXDTMxMDExNTA4MzUwN1owgZ0xCzAJBgNVBAYT
AlVTMRMwEQYDVQQIDApDYWxpZm9ybmlhMRIwEAYDVQQHDAlTdW5ueXZhbGUxETAP
BgNVBAoMCEZvcnRpbmV0MRIwEAYDVQQLDAlGb3J0aUdhdGUxGTAXBgNVBAMMEEZH
VDQwRlRLMjAwNTMwMjMxIzAhBgkqhkiG9w0BCQEWFHN1cHBvcnRAZm9ydGluZXQu
Y29tMFkwEwYHKoZIzj0CAQYIKoZIzj0DAQcDQgAEFeR69+DlDmZL0aA7yjyPRQB5
mP29XnvWKpOT2ddZb6odEmGGRuiIxXKa1rxQToH/r8vxsymym+vcnDIHGbJMUKMN
MAswCQYDVR0TBAIwADAKBggqhkjOPQQDAgNHADBEAiAkawJ/jS91y0earNLfWo5m
Ji5u+hjR8HEU/RSTmJ/tPgIgPUAgpgKdwVI9CqSHCIaZwBr7tt8ygIzqnqwLKwjV
LM4=
-----END CERTIFICATE-----"
        set range global
        set source factory
        set last-updated 1597100049
    next
    edit "Fortinet_SSL_ECDSA384"
        set password ENC URuaaazOHoPSNjPk31XAKzJfOsO85hCxNOv1PTYjgoHZIcd4OB4ax3MaYoCDLSaog2ZNruBpYp32fyMNLK6Uo5E4rIFU6K9c5dhOcie1Ogx4loKfxhkjKGhaKHDp4iyJJGLXTmWBoMCXTNgZcgPOfytWvqdrf6Sbp6JWdYjKU0UyABlpVgoripo3tPwrlO9l5IjM4w==
        set comments "This certificate is embedded in the hardware at the factory and is unique to this unit. "
        set private-key "-----BEGIN ENCRYPTED PRIVATE KEY-----
MIIBEzBOBgkqhkiG9w0BBQ0wQTApBgkqhkiG9w0BBQwwHAQIPwjZKlAF5L4CAggA
MAwGCCqGSIb3DQIJBQAwFAYIKoZIhvcNAwcECJ09ZBYRe7Z1BIHADj3ERY4TGw25
aISRzIFshGTI8gS1vdfsnGoLmPW96lI9HiSgb89h5Pcv/wiFmmgSDsfJiw28VxEn
YM39P7dpkheL1SApRPUOuuXwTyuc1iJPwJwurdSH98UfV9sxv842vvMvyxiqn9bg
Z4goEOz9uGJsKY2eQVOgUjXyDxHcjWTPXkyuuIbbVzIKf6RwuTDltBOCQuJAA/IR
pIlgk+HSceekEhWeSITUPdcsuw6NuGVlg0ti4dIs2NNx4P4pfwOe
-----END ENCRYPTED PRIVATE KEY-----"
        set certificate "-----BEGIN CERTIFICATE-----
MIICezCCAgKgAwIBAgIIYzV9KY7LXvUwCgYIKoZIzj0EAwIwgZ0xCzAJBgNVBAYT
AlVTMRMwEQYDVQQIDApDYWxpZm9ybmlhMRIwEAYDVQQHDAlTdW5ueXZhbGUxETAP
BgNVBAoMCEZvcnRpbmV0MRIwEAYDVQQLDAlGb3J0aUdhdGUxGTAXBgNVBAMMEEZH
VDQwRlRLMjAwNTMwMjMxIzAhBgkqhkiG9w0BCQEWFHN1cHBvcnRAZm9ydGluZXQu
Y29tMB4XDTIxMDExNDA4MzUwN1oXDTMxMDExNTA4MzUwN1owgZ0xCzAJBgNVBAYT
AlVTMRMwEQYDVQQIDApDYWxpZm9ybmlhMRIwEAYDVQQHDAlTdW5ueXZhbGUxETAP
BgNVBAoMCEZvcnRpbmV0MRIwEAYDVQQLDAlGb3J0aUdhdGUxGTAXBgNVBAMMEEZH
VDQwRlRLMjAwNTMwMjMxIzAhBgkqhkiG9w0BCQEWFHN1cHBvcnRAZm9ydGluZXQu
Y29tMHYwEAYHKoZIzj0CAQYFK4EEACIDYgAExJKhrsVCP0rqR2YWuSeBiMGAaCqF
wTQUpJKcrdY3Ey/4r2RoBKmwvCzUvjuO4AsN9QYCFXqNkMY4+jd566B5ItZSaqHX
86NPu7km+e3qrHWEM+/9dZ+oyAgoyZs1n++Eow0wCzAJBgNVHRMEAjAAMAoGCCqG
SM49BAMCA2cAMGQCMD+Rcz3TdpAL835ifzbwjSooRcEPgHBjCWFbrJMHrczMnLCT
3bbubFrpP0Y7+76ynwIwRlQduZ2WKWTa9JGzoVDs0nECOq4BE6c13vg7/QlP5aRl
eCv0MeCbt10ZfFDqULsX
-----END CERTIFICATE-----"
        set range global
        set source factory
        set last-updated 1597100049
    next
end
config user local
    edit "guest"
        set type password
        set passwd ENC ns2UJSFAFVcpRakS0fsWV6wRgJ6TfYY0H20JM/J5TnpOiCXJt+vTx3cRlmkE0tkp5oMgGy5PDvLhTx3FWPGyaj7jk+UChXYX/32cvTf3jlH230Zecyn0YGn+V6ujgoVcc6kWHtS5D5iZp3MbPioGS08EJO/y+yewIOtHg7wUjtV7B9xZQy0Rvqn1wBhhEI99cwuMEw==
    next
end
config user setting
    set auth-cert "Fortinet_Factory"
end
config user group
    edit "SSO_Guest_Users"
    next
    edit "Guest-group"
        set member "guest"
    next
end
config user device-group
    edit "Mobile Devices"
        set member "android-phone" "android-tablet" "blackberry-phone" "blackberry-playbook" "ipad" "iphone" "windows-phone" "windows-tablet"
        set comment "Phones, tablets, etc."
    next
    edit "Network Devices"
        set member "fortinet-device" "other-network-device" "router-nat-device"
        set comment "Routers, firewalls, gateways, etc."
    next
    edit "Others"
        set member "gaming-console" "media-streaming"
        set comment "Other devices."
    next
end
config vpn ssl web host-check-software
    edit "FortiClient-AV"
        set guid "C86EC76D-5A4C-40E7-BD94-59358E544D81"
    next
    edit "FortiClient-FW"
        set type fw
        set guid "528CB157-D384-4593-AAAA-E42DFF111CED"
    next
    edit "FortiClient-AV-Vista"
        set guid "385618A6-2256-708E-3FB9-7E98B93F91F9"
    next
    edit "FortiClient-FW-Vista"
        set type fw
        set guid "006D9983-6839-71D6-14E6-D7AD47ECD682"
    next
    edit "FortiClient-AV-Win7"
        set guid "71629DC5-BE6F-CCD3-C5A5-014980643264"
    next
    edit "AVG-Internet-Security-AV"
        set guid "17DDD097-36FF-435F-9E1B-52D74245D6BF"
    next
    edit "AVG-Internet-Security-FW"
        set type fw
        set guid "8DECF618-9569-4340-B34A-D78D28969B66"
    next
    edit "AVG-Internet-Security-AV-Vista-Win7"
        set guid "0C939084-9E57-CBDB-EA61-0B0C7F62AF82"
    next
    edit "AVG-Internet-Security-FW-Vista-Win7"
        set type fw
        set guid "34A811A1-D438-CA83-C13E-A23981B1E8F9"
    next
    edit "CA-Anti-Virus"
        set guid "17CFD1EA-56CF-40B5-A06B-BD3A27397C93"
    next
    edit "CA-Internet-Security-AV"
        set guid "6B98D35F-BB76-41C0-876B-A50645ED099A"
    next
    edit "CA-Internet-Security-FW"
        set type fw
        set guid "38102F93-1B6E-4922-90E1-A35D8DC6DAA3"
    next
    edit "CA-Internet-Security-AV-Vista-Win7"
        set guid "3EED0195-0A4B-4EF3-CC4F-4F401BDC245F"
    next
    edit "CA-Internet-Security-FW-Vista-Win7"
        set type fw
        set guid "06D680B0-4024-4FAB-E710-E675E50F6324"
    next
    edit "CA-Personal-Firewall"
        set type fw
        set guid "14CB4B80-8E52-45EA-905E-67C1267B4160"
    next
    edit "F-Secure-Internet-Security-AV"
        set guid "E7512ED5-4245-4B4D-AF3A-382D3F313F15"
    next
    edit "F-Secure-Internet-Security-FW"
        set type fw
        set guid "D4747503-0346-49EB-9262-997542F79BF4"
    next
    edit "F-Secure-Internet-Security-AV-Vista-Win7"
        set guid "15414183-282E-D62C-CA37-EF24860A2F17"
    next
    edit "F-Secure-Internet-Security-FW-Vista-Win7"
        set type fw
        set guid "2D7AC0A6-6241-D774-E168-461178D9686C"
    next
    edit "Kaspersky-AV"
        set guid "2C4D4BC6-0793-4956-A9F9-E252435469C0"
    next
    edit "Kaspersky-FW"
        set type fw
        set guid "2C4D4BC6-0793-4956-A9F9-E252435469C0"
    next
    edit "Kaspersky-AV-Vista-Win7"
        set guid "AE1D740B-8F0F-D137-211D-873D44B3F4AE"
    next
    edit "Kaspersky-FW-Vista-Win7"
        set type fw
        set guid "9626F52E-C560-D06F-0A42-2E08BA60B3D5"
    next
    edit "McAfee-Internet-Security-Suite-AV"
        set guid "84B5EE75-6421-4CDE-A33A-DD43BA9FAD83"
    next
    edit "McAfee-Internet-Security-Suite-FW"
        set type fw
        set guid "94894B63-8C7F-4050-BDA4-813CA00DA3E8"
    next
    edit "McAfee-Internet-Security-Suite-AV-Vista-Win7"
        set guid "86355677-4064-3EA7-ABB3-1B136EB04637"
    next
    edit "McAfee-Internet-Security-Suite-FW-Vista-Win7"
        set type fw
        set guid "BE0ED752-0A0B-3FFF-80EC-B2269063014C"
    next
    edit "McAfee-Virus-Scan-Enterprise"
        set guid "918A2B0B-2C60-4016-A4AB-E868DEABF7F0"
    next
    edit "Norton-360-2.0-AV"
        set guid "A5F1BC7C-EA33-4247-961C-0217208396C4"
    next
    edit "Norton-360-2.0-FW"
        set type fw
        set guid "371C0A40-5A0C-4AD2-A6E5-69C02037FBF3"
    next
    edit "Norton-360-3.0-AV"
        set guid "E10A9785-9598-4754-B552-92431C1C35F8"
    next
    edit "Norton-360-3.0-FW"
        set type fw
        set guid "7C21A4C9-F61F-4AC4-B722-A6E19C16F220"
    next
    edit "Norton-Internet-Security-AV"
        set guid "E10A9785-9598-4754-B552-92431C1C35F8"
    next
    edit "Norton-Internet-Security-FW"
        set type fw
        set guid "7C21A4C9-F61F-4AC4-B722-A6E19C16F220"
    next
    edit "Norton-Internet-Security-AV-Vista-Win7"
        set guid "88C95A36-8C3B-2F2C-1B8B-30FCCFDC4855"
    next
    edit "Norton-Internet-Security-FW-Vista-Win7"
        set type fw
        set guid "B0F2DB13-C654-2E74-30D4-99C9310F0F2E"
    next
    edit "Symantec-Endpoint-Protection-AV"
        set guid "FB06448E-52B8-493A-90F3-E43226D3305C"
    next
    edit "Symantec-Endpoint-Protection-FW"
        set type fw
        set guid "BE898FE3-CD0B-4014-85A9-03DB9923DDB6"
    next
    edit "Symantec-Endpoint-Protection-AV-Vista-Win7"
        set guid "88C95A36-8C3B-2F2C-1B8B-30FCCFDC4855"
    next
    edit "Symantec-Endpoint-Protection-FW-Vista-Win7"
        set type fw
        set guid "B0F2DB13-C654-2E74-30D4-99C9310F0F2E"
    next
    edit "Panda-Antivirus+Firewall-2008-AV"
        set guid "EEE2D94A-D4C1-421A-AB2C-2CE8FE51747A"
    next
    edit "Panda-Antivirus+Firewall-2008-FW"
        set type fw
        set guid "7B090DC0-8905-4BAF-8040-FD98A41C8FB8"
    next
    edit "Panda-Internet-Security-AV"
        set guid "4570FB70-5C9E-47E9-B16C-A3A6A06C4BF0"
    next
    edit "Panda-Internet-Security-2006~2007-FW"
        set type fw
        set guid "4570FB70-5C9E-47E9-B16C-A3A6A06C4BF0"
    next
    edit "Panda-Internet-Security-2008~2009-FW"
        set type fw
        set guid "7B090DC0-8905-4BAF-8040-FD98A41C8FB8"
    next
    edit "Sophos-Anti-Virus"
        set guid "3F13C776-3CBE-4DE9-8BF6-09E5183CA2BD"
    next
    edit "Sophos-Enpoint-Secuirty-and-Control-FW"
        set type fw
        set guid "0786E95E-326A-4524-9691-41EF88FB52EA"
    next
    edit "Sophos-Enpoint-Secuirty-and-Control-AV-Vista-Win7"
        set guid "479CCF92-4960-B3E0-7373-BF453B467D2C"
    next
    edit "Sophos-Enpoint-Secuirty-and-Control-FW-Vista-Win7"
        set type fw
        set guid "7FA74EB7-030F-B2B8-582C-1670C5953A57"
    next
    edit "Trend-Micro-AV"
        set guid "7D2296BC-32CC-4519-917E-52E652474AF5"
    next
    edit "Trend-Micro-FW"
        set type fw
        set guid "3E790E9E-6A5D-4303-A7F9-185EC20F3EB6"
    next
    edit "Trend-Micro-AV-Vista-Win7"
        set guid "48929DFC-7A52-A34F-8351-C4DBEDBD9C50"
    next
    edit "Trend-Micro-FW-Vista-Win7"
        set type fw
        set guid "70A91CD9-303D-A217-A80E-6DEE136EDB2B"
    next
    edit "ZoneAlarm-AV"
        set guid "5D467B10-818C-4CAB-9FF7-6893B5B8F3CF"
    next
    edit "ZoneAlarm-FW"
        set type fw
        set guid "829BDA32-94B3-44F4-8446-F8FCFF809F8B"
    next
    edit "ZoneAlarm-AV-Vista-Win7"
        set guid "D61596DF-D219-341C-49B3-AD30538CBC5B"
    next
    edit "ZoneAlarm-FW-Vista-Win7"
        set type fw
        set guid "EE2E17FA-9876-3544-62EC-0405AD5FFB20"
    next
    edit "ESET-Smart-Security-AV"
        set guid "19259FAE-8396-A113-46DB-15B0E7DFA289"
    next
    edit "ESET-Smart-Security-FW"
        set type fw
        set guid "211E1E8B-C9F9-A04B-6D84-BC85190CE5F2"
    next
end
config vpn ssl web portal
    edit "full-access"
        set tunnel-mode enable
        set ipv6-tunnel-mode enable
        set web-mode enable
        set ip-pools "SSLVPN_TUNNEL_ADDR1"
        set ipv6-pools "SSLVPN_TUNNEL_IPv6_ADDR1"
    next
end
config vpn ssl settings
    set servercert "Fortinet_Factory"
    set port 443
end
config voip profile
    edit "default"
        set comment "Default VoIP profile."
    next
    edit "strict"
        config sip
            set malformed-request-line discard
            set malformed-header-via discard
            set malformed-header-from discard
            set malformed-header-to discard
            set malformed-header-call-id discard
            set malformed-header-cseq discard
            set malformed-header-rack discard
            set malformed-header-rseq discard
            set malformed-header-contact discard
            set malformed-header-record-route discard
            set malformed-header-route discard
            set malformed-header-expires discard
            set malformed-header-content-type discard
            set malformed-header-content-length discard
            set malformed-header-max-forwards discard
            set malformed-header-allow discard
            set malformed-header-p-asserted-identity discard
            set malformed-header-sdp-v discard
            set malformed-header-sdp-o discard
            set malformed-header-sdp-s discard
            set malformed-header-sdp-i discard
            set malformed-header-sdp-c discard
            set malformed-header-sdp-b discard
            set malformed-header-sdp-z discard
            set malformed-header-sdp-k discard
            set malformed-header-sdp-a discard
            set malformed-header-sdp-t discard
            set malformed-header-sdp-r discard
            set malformed-header-sdp-m discard
        end
    next
end
config webfilter profile
    edit "default"
        set comment "Default web filtering."
        set inspection-mode flow-based
        config ftgd-wf
            unset options
            config filters
                edit 1
                    set category 2
                    set action block
                next
                edit 2
                    set category 7
                    set action block
                next
                edit 3
                    set category 8
                    set action block
                next
                edit 4
                    set category 9
                    set action block
                next
                edit 5
                    set category 11
                    set action block
                next
                edit 6
                    set category 12
                    set action block
                next
                edit 7
                    set category 13
                    set action block
                next
                edit 8
                    set category 14
                    set action block
                next
                edit 9
                    set category 15
                    set action block
                next
                edit 10
                    set category 16
                    set action block
                next
                edit 11
                    set action block
                next
                edit 12
                    set category 57
                    set action block
                next
                edit 13
                    set category 63
                    set action block
                next
                edit 14
                    set category 64
                    set action block
                next
                edit 15
                    set category 65
                    set action block
                next
                edit 16
                    set category 66
                    set action block
                next
                edit 17
                    set category 67
                    set action block
                next
                edit 18
                    set category 26
                    set action block
                next
                edit 19
                    set category 61
                    set action block
                next
                edit 20
                    set category 86
                    set action block
                next
                edit 21
                    set category 88
                    set action block
                next
                edit 22
                    set category 90
                    set action block
                next
                edit 23
                    set category 91
                    set action block
                next
            end
        end
    next
    edit "sniffer-profile"
        set comment "Monitor web traffic."
        set inspection-mode flow-based
        config ftgd-wf
            config filters
                edit 1
                next
                edit 2
                    set category 1
                next
                edit 3
                    set category 2
                next
                edit 4
                    set category 3
                next
                edit 5
                    set category 4
                next
                edit 6
                    set category 5
                next
                edit 7
                    set category 6
                next
                edit 8
                    set category 7
                next
                edit 9
                    set category 8
                next
                edit 10
                    set category 9
                next
                edit 11
                    set category 11
                next
                edit 12
                    set category 12
                next
                edit 13
                    set category 13
                next
                edit 14
                    set category 14
                next
                edit 15
                    set category 15
                next
                edit 16
                    set category 16
                next
                edit 17
                    set category 17
                next
                edit 18
                    set category 18
                next
                edit 19
                    set category 19
                next
                edit 20
                    set category 20
                next
                edit 21
                    set category 23
                next
                edit 22
                    set category 24
                next
                edit 23
                    set category 25
                next
                edit 24
                    set category 26
                next
                edit 25
                    set category 28
                next
                edit 26
                    set category 29
                next
                edit 27
                    set category 30
                next
                edit 28
                    set category 31
                next
                edit 29
                    set category 33
                next
                edit 30
                    set category 34
                next
                edit 31
                    set category 35
                next
                edit 32
                    set category 36
                next
                edit 33
                    set category 37
                next
                edit 34
                    set category 38
                next
                edit 35
                    set category 39
                next
                edit 36
                    set category 40
                next
                edit 37
                    set category 41
                next
                edit 38
                    set category 42
                next
                edit 39
                    set category 43
                next
                edit 40
                    set category 44
                next
                edit 41
                    set category 46
                next
                edit 42
                    set category 47
                next
                edit 43
                    set category 48
                next
                edit 44
                    set category 49
                next
                edit 45
                    set category 50
                next
                edit 46
                    set category 51
                next
                edit 47
                    set category 52
                next
                edit 48
                    set category 53
                next
                edit 49
                    set category 54
                next
                edit 50
                    set category 55
                next
                edit 51
                    set category 56
                next
                edit 52
                    set category 57
                next
                edit 53
                    set category 58
                next
                edit 54
                    set category 59
                next
                edit 55
                    set category 61
                next
                edit 56
                    set category 62
                next
                edit 57
                    set category 63
                next
                edit 58
                    set category 64
                next
                edit 59
                    set category 65
                next
                edit 60
                    set category 66
                next
                edit 61
                    set category 67
                next
                edit 62
                    set category 68
                next
                edit 63
                    set category 69
                next
                edit 64
                    set category 70
                next
                edit 65
                    set category 71
                next
                edit 66
                    set category 72
                next
                edit 67
                    set category 75
                next
                edit 68
                    set category 76
                next
                edit 69
                    set category 77
                next
                edit 70
                    set category 78
                next
                edit 71
                    set category 79
                next
                edit 72
                    set category 80
                next
                edit 73
                    set category 81
                next
                edit 74
                    set category 82
                next
                edit 75
                    set category 83
                next
                edit 76
                    set category 84
                next
                edit 77
                    set category 85
                next
                edit 78
                    set category 86
                next
                edit 79
                    set category 87
                next
                edit 80
                    set category 88
                next
                edit 81
                    set category 89
                next
                edit 82
                    set category 90
                next
                edit 83
                    set category 91
                next
                edit 84
                    set category 92
                next
                edit 85
                    set category 93
                next
                edit 86
                    set category 94
                next
                edit 87
                    set category 95
                next
            end
        end
    next
    edit "wifi-default"
        set comment "Default configuration for offloading WiFi traffic."
        set inspection-mode flow-based
        set options block-invalid-url
        config ftgd-wf
            unset options
            config filters
                edit 1
                next
                edit 2
                    set category 2
                    set action block
                next
                edit 3
                    set category 7
                    set action block
                next
                edit 4
                    set category 8
                    set action block
                next
                edit 5
                    set category 9
                    set action block
                next
                edit 6
                    set category 11
                    set action block
                next
                edit 7
                    set category 12
                    set action block
                next
                edit 8
                    set category 13
                    set action block
                next
                edit 9
                    set category 14
                    set action block
                next
                edit 10
                    set category 15
                    set action block
                next
                edit 11
                    set category 16
                    set action block
                next
                edit 12
                    set category 26
                    set action block
                next
                edit 13
                    set category 57
                    set action block
                next
                edit 14
                    set category 61
                    set action block
                next
                edit 15
                    set category 63
                    set action block
                next
                edit 16
                    set category 64
                    set action block
                next
                edit 17
                    set category 65
                    set action block
                next
                edit 18
                    set category 66
                    set action block
                next
                edit 19
                    set category 67
                    set action block
                next
                edit 20
                    set category 86
                    set action block
                next
                edit 21
                    set category 88
                    set action block
                next
                edit 22
                    set category 90
                    set action block
                next
                edit 23
                    set category 91
                    set action block
                next
            end
        end
    next
    edit "monitor-all"
        set comment "Monitor and log all visited URLs, flow-based."
        set inspection-mode flow-based
        config ftgd-wf
            unset options
            config filters
                edit 1
                    set category 1
                next
                edit 2
                    set category 3
                next
                edit 3
                    set category 4
                next
                edit 4
                    set category 5
                next
                edit 5
                    set category 6
                next
                edit 6
                    set category 12
                next
                edit 7
                    set category 59
                next
                edit 8
                    set category 62
                next
                edit 9
                    set category 83
                next
                edit 10
                    set category 2
                next
                edit 11
                    set category 7
                next
                edit 12
                    set category 8
                next
                edit 13
                    set category 9
                next
                edit 14
                    set category 11
                next
                edit 15
                    set category 13
                next
                edit 16
                    set category 14
                next
                edit 17
                    set category 15
                next
                edit 18
                    set category 16
                next
                edit 19
                    set category 57
                next
                edit 20
                    set category 63
                next
                edit 21
                    set category 64
                next
                edit 22
                    set category 65
                next
                edit 23
                    set category 66
                next
                edit 24
                    set category 67
                next
                edit 25
                    set category 19
                next
                edit 26
                    set category 24
                next
                edit 27
                    set category 25
                next
                edit 28
                    set category 72
                next
                edit 29
                    set category 75
                next
                edit 30
                    set category 76
                next
                edit 31
                    set category 26
                next
                edit 32
                    set category 61
                next
                edit 33
                    set category 86
                next
                edit 34
                    set category 17
                next
                edit 35
                    set category 18
                next
                edit 36
                    set category 20
                next
                edit 37
                    set category 23
                next
                edit 38
                    set category 28
                next
                edit 39
                    set category 29
                next
                edit 40
                    set category 30
                next
                edit 41
                    set category 33
                next
                edit 42
                    set category 34
                next
                edit 43
                    set category 35
                next
                edit 44
                    set category 36
                next
                edit 45
                    set category 37
                next
                edit 46
                    set category 38
                next
                edit 47
                    set category 39
                next
                edit 48
                    set category 40
                next
                edit 49
                    set category 42
                next
                edit 50
                    set category 44
                next
                edit 51
                    set category 46
                next
                edit 52
                    set category 47
                next
                edit 53
                    set category 48
                next
                edit 54
                    set category 54
                next
                edit 55
                    set category 55
                next
                edit 56
                    set category 58
                next
                edit 57
                    set category 68
                next
                edit 58
                    set category 69
                next
                edit 59
                    set category 70
                next
                edit 60
                    set category 71
                next
                edit 61
                    set category 77
                next
                edit 62
                    set category 78
                next
                edit 63
                    set category 79
                next
                edit 64
                    set category 80
                next
                edit 65
                    set category 82
                next
                edit 66
                    set category 85
                next
                edit 67
                    set category 87
                next
                edit 68
                    set category 31
                next
                edit 69
                    set category 41
                next
                edit 70
                    set category 43
                next
                edit 71
                    set category 49
                next
                edit 72
                    set category 50
                next
                edit 73
                    set category 51
                next
                edit 74
                    set category 52
                next
                edit 75
                    set category 53
                next
                edit 76
                    set category 56
                next
                edit 77
                    set category 81
                next
                edit 78
                    set category 84
                next
                edit 79
                next
                edit 80
                    set category 88
                next
                edit 81
                    set category 89
                next
                edit 82
                    set category 90
                next
                edit 83
                    set category 91
                next
                edit 84
                    set category 92
                next
                edit 85
                    set category 93
                next
                edit 86
                    set category 94
                next
                edit 87
                    set category 95
                next
            end
        end
        set log-all-url enable
        set web-content-log disable
        set web-filter-activex-log disable
        set web-filter-command-block-log disable
        set web-filter-cookie-log disable
        set web-filter-applet-log disable
        set web-filter-jscript-log disable
        set web-filter-js-log disable
        set web-filter-vbs-log disable
        set web-filter-unknown-log disable
        set web-filter-referer-log disable
        set web-filter-cookie-removal-log disable
        set web-url-log disable
        set web-invalid-domain-log disable
        set web-ftgd-err-log disable
        set web-ftgd-quota-usage disable
    next
end
config webfilter search-engine
    edit "google"
        set hostname ".*\\.google\\..*"
        set url "^\\/((custom|search|images|videosearch|webhp)\\?)"
        set query "q="
        set safesearch url
        set safesearch-str "&safe=active"
    next
    edit "yahoo"
        set hostname ".*\\.yahoo\\..*"
        set url "^\\/search(\\/video|\\/images){0,1}(\\?|;)"
        set query "p="
        set safesearch url
        set safesearch-str "&vm=r"
    next
    edit "bing"
        set hostname ".*\\.bing\\..*"
        set url "^(\\/images|\\/videos)?(\\/search|\\/async|\\/asyncv2)\\?"
        set query "q="
        set safesearch header
    next
    edit "yandex"
        set hostname "yandex\\..*"
        set url "^\\/((yand|images\\/|video\\/)(search)|search\\/)\\?"
        set query "text="
        set safesearch url
        set safesearch-str "&family=yes"
    next
    edit "youtube"
        set hostname ".*youtube.*"
        set safesearch header
    next
    edit "baidu"
        set hostname ".*\\.baidu\\.com"
        set url "^\\/s?\\?"
        set query "wd="
    next
    edit "baidu2"
        set hostname ".*\\.baidu\\.com"
        set url "^\\/(ns|q|m|i|v)\\?"
        set query "word="
    next
    edit "baidu3"
        set hostname "tieba\\.baidu\\.com"
        set url "^\\/f\\?"
        set query "kw="
    next
end
config dnsfilter profile
    edit "default"
        set comment "Default dns filtering."
        config ftgd-dns
            config filters
                edit 1
                    set category 2
                next
                edit 2
                    set category 7
                next
                edit 3
                    set category 8
                next
                edit 4
                    set category 9
                next
                edit 5
                    set category 11
                next
                edit 6
                    set category 12
                next
                edit 7
                    set category 13
                next
                edit 8
                    set category 14
                next
                edit 9
                    set category 15
                next
                edit 10
                    set category 16
                next
                edit 11
                next
                edit 12
                    set category 57
                next
                edit 13
                    set category 63
                next
                edit 14
                    set category 64
                next
                edit 15
                    set category 65
                next
                edit 16
                    set category 66
                next
                edit 17
                    set category 67
                next
                edit 18
                    set category 26
                    set action block
                next
                edit 19
                    set category 61
                    set action block
                next
                edit 20
                    set category 86
                    set action block
                next
                edit 21
                    set category 88
                    set action block
                next
                edit 22
                    set category 90
                    set action block
                next
                edit 23
                    set category 91
                    set action block
                next
            end
        end
        set block-botnet enable
    next
end
config antivirus settings
    set grayware enable
end
config antivirus profile
    edit "default"
        set comment "Scan files and block viruses."
        config http
            set options scan
        end
        config ftp
            set options scan
        end
        config imap
            set options scan
            set executables virus
        end
        config pop3
            set options scan
            set executables virus
        end
        config smtp
            set options scan
            set executables virus
        end
    next
    edit "sniffer-profile"
        set comment "Scan files and monitor viruses."
        config http
            set options scan
        end
        config ftp
            set options scan
        end
        config imap
            set options scan
            set executables virus
        end
        config pop3
            set options scan
            set executables virus
        end
        config smtp
            set options scan
            set executables virus
        end
    next
    edit "wifi-default"
        set comment "Default configuration for offloading WiFi traffic."
        config http
            set options scan
        end
        config ftp
            set options scan
        end
        config imap
            set options scan
            set executables virus
        end
        config pop3
            set options scan
            set executables virus
        end
        config smtp
            set options scan
            set executables virus
        end
    next
end
config spamfilter profile
    edit "sniffer-profile"
        set comment "Malware and phishing URL monitoring."
        set flow-based enable
    next
    edit "default"
        set comment "Malware and phishing URL filtering."
    next
end
config firewall schedule recurring
    edit "always"
        set day sunday monday tuesday wednesday thursday friday saturday
    next
    edit "none"
    next
end
config firewall profile-protocol-options
    edit "default"
        set comment "All default services."
        config http
            set ports 80
            unset options
            unset post-lang
        end
        config ftp
            set ports 21
            set options splice
        end
        config imap
            set ports 143
            set options fragmail
        end
        config mapi
            set ports 135
            set options fragmail
        end
        config pop3
            set ports 110
            set options fragmail
        end
        config smtp
            set ports 25
            set options fragmail splice
        end
        config nntp
            set ports 119
            set options splice
        end
        config dns
            set ports 53
        end
    next
end
config firewall ssl-ssh-profile
    edit "deep-inspection"
        set comment "Read-only deep inspection profile."
        config https
            set ports 443
        end
        config ftps
            set ports 990
        end
        config imaps
            set ports 993
        end
        config pop3s
            set ports 995
        end
        config smtps
            set ports 465
        end
        config ssh
            set ports 22
        end
        config ssl-exempt
            edit 1
                set fortiguard-category 31
            next
            edit 2
                set fortiguard-category 33
            next
            edit 3
                set type wildcard-fqdn
                set wildcard-fqdn "adobe"
            next
            edit 4
                set type wildcard-fqdn
                set wildcard-fqdn "Adobe Login"
            next
            edit 5
                set type wildcard-fqdn
                set wildcard-fqdn "android"
            next
            edit 6
                set type wildcard-fqdn
                set wildcard-fqdn "apple"
            next
            edit 7
                set type wildcard-fqdn
                set wildcard-fqdn "appstore"
            next
            edit 8
                set type wildcard-fqdn
                set wildcard-fqdn "auth.gfx.ms"
            next
            edit 9
                set type wildcard-fqdn
                set wildcard-fqdn "citrix"
            next
            edit 10
                set type wildcard-fqdn
                set wildcard-fqdn "dropbox.com"
            next
            edit 11
                set type wildcard-fqdn
                set wildcard-fqdn "eease"
            next
            edit 12
                set type wildcard-fqdn
                set wildcard-fqdn "firefox update server"
            next
            edit 13
                set type wildcard-fqdn
                set wildcard-fqdn "fortinet"
            next
            edit 14
                set type wildcard-fqdn
                set wildcard-fqdn "googleapis.com"
            next
            edit 15
                set type wildcard-fqdn
                set wildcard-fqdn "google-drive"
            next
            edit 16
                set type wildcard-fqdn
                set wildcard-fqdn "google-play2"
            next
            edit 17
                set type wildcard-fqdn
                set wildcard-fqdn "google-play3"
            next
            edit 18
                set type wildcard-fqdn
                set wildcard-fqdn "Gotomeeting"
            next
            edit 19
                set type wildcard-fqdn
                set wildcard-fqdn "icloud"
            next
            edit 20
                set type wildcard-fqdn
                set wildcard-fqdn "itunes"
            next
            edit 21
                set type wildcard-fqdn
                set wildcard-fqdn "microsoft"
            next
            edit 22
                set type wildcard-fqdn
                set wildcard-fqdn "skype"
            next
            edit 23
                set type wildcard-fqdn
                set wildcard-fqdn "softwareupdate.vmware.com"
            next
            edit 24
                set type wildcard-fqdn
                set wildcard-fqdn "verisign"
            next
            edit 25
                set type wildcard-fqdn
                set wildcard-fqdn "Windows update 2"
            next
            edit 26
                set type wildcard-fqdn
                set wildcard-fqdn "live.com"
            next
            edit 27
                set type wildcard-fqdn
                set wildcard-fqdn "google-play"
            next
            edit 28
                set type wildcard-fqdn
                set wildcard-fqdn "update.microsoft.com"
            next
            edit 29
                set type wildcard-fqdn
                set wildcard-fqdn "swscan.apple.com"
            next
            edit 30
                set type wildcard-fqdn
                set wildcard-fqdn "autoupdate.opera.com"
            next
        end
    next
    edit "custom-deep-inspection"
        set comment "Customizable deep inspection profile."
        config https
            set ports 443
        end
        config ftps
            set ports 990
        end
        config imaps
            set ports 993
        end
        config pop3s
            set ports 995
        end
        config smtps
            set ports 465
        end
        config ssh
            set ports 22
        end
        config ssl-exempt
            edit 1
                set fortiguard-category 31
            next
            edit 2
                set fortiguard-category 33
            next
            edit 3
                set type wildcard-fqdn
                set wildcard-fqdn "adobe"
            next
            edit 4
                set type wildcard-fqdn
                set wildcard-fqdn "Adobe Login"
            next
            edit 5
                set type wildcard-fqdn
                set wildcard-fqdn "android"
            next
            edit 6
                set type wildcard-fqdn
                set wildcard-fqdn "apple"
            next
            edit 7
                set type wildcard-fqdn
                set wildcard-fqdn "appstore"
            next
            edit 8
                set type wildcard-fqdn
                set wildcard-fqdn "auth.gfx.ms"
            next
            edit 9
                set type wildcard-fqdn
                set wildcard-fqdn "citrix"
            next
            edit 10
                set type wildcard-fqdn
                set wildcard-fqdn "dropbox.com"
            next
            edit 11
                set type wildcard-fqdn
                set wildcard-fqdn "eease"
            next
            edit 12
                set type wildcard-fqdn
                set wildcard-fqdn "firefox update server"
            next
            edit 13
                set type wildcard-fqdn
                set wildcard-fqdn "fortinet"
            next
            edit 14
                set type wildcard-fqdn
                set wildcard-fqdn "googleapis.com"
            next
            edit 15
                set type wildcard-fqdn
                set wildcard-fqdn "google-drive"
            next
            edit 16
                set type wildcard-fqdn
                set wildcard-fqdn "google-play2"
            next
            edit 17
                set type wildcard-fqdn
                set wildcard-fqdn "google-play3"
            next
            edit 18
                set type wildcard-fqdn
                set wildcard-fqdn "Gotomeeting"
            next
            edit 19
                set type wildcard-fqdn
                set wildcard-fqdn "icloud"
            next
            edit 20
                set type wildcard-fqdn
                set wildcard-fqdn "itunes"
            next
            edit 21
                set type wildcard-fqdn
                set wildcard-fqdn "microsoft"
            next
            edit 22
                set type wildcard-fqdn
                set wildcard-fqdn "skype"
            next
            edit 23
                set type wildcard-fqdn
                set wildcard-fqdn "softwareupdate.vmware.com"
            next
            edit 24
                set type wildcard-fqdn
                set wildcard-fqdn "verisign"
            next
            edit 25
                set type wildcard-fqdn
                set wildcard-fqdn "Windows update 2"
            next
            edit 26
                set type wildcard-fqdn
                set wildcard-fqdn "live.com"
            next
            edit 27
                set type wildcard-fqdn
                set wildcard-fqdn "google-play"
            next
            edit 28
                set type wildcard-fqdn
                set wildcard-fqdn "update.microsoft.com"
            next
            edit 29
                set type wildcard-fqdn
                set wildcard-fqdn "swscan.apple.com"
            next
            edit 30
                set type wildcard-fqdn
                set wildcard-fqdn "autoupdate.opera.com"
            next
        end
    next
    edit "certificate-inspection"
        set comment "Read-only SSL handshake inspection profile."
        config https
            set ports 443
            set status certificate-inspection
        end
        config ftps
            set status disable
        end
        config imaps
            set status disable
        end
        config pop3s
            set status disable
        end
        config smtps
            set status disable
        end
        config ssh
            set ports 22
            set status disable
        end
    next
end
config waf profile
    edit "default"
        config signature
            config main-class 100000000
                set action block
                set severity high
            end
            config main-class 20000000
            end
            config main-class 30000000
                set status enable
                set action block
                set severity high
            end
            config main-class 40000000
            end
            config main-class 50000000
                set status enable
                set action block
                set severity high
            end
            config main-class 60000000
            end
            config main-class 70000000
                set status enable
                set action block
                set severity high
            end
            config main-class 80000000
                set status enable
                set severity low
            end
            config main-class 110000000
                set status enable
                set severity high
            end
            config main-class 90000000
                set status enable
                set action block
                set severity high
            end
            set disabled-signature 80080005 80200001 60030001 60120001 80080003 90410001 90410002
        end
        config constraint
            config header-length
                set status enable
                set log enable
                set severity low
            end
            config content-length
                set status enable
                set log enable
                set severity low
            end
            config param-length
                set status enable
                set log enable
                set severity low
            end
            config line-length
                set status enable
                set log enable
                set severity low
            end
            config url-param-length
                set status enable
                set log enable
                set severity low
            end
            config version
                set log enable
            end
            config method
                set action block
                set log enable
            end
            config hostname
                set action block
                set log enable
            end
            config malformed
                set log enable
            end
            config max-cookie
                set status enable
                set log enable
                set severity low
            end
            config max-header-line
                set status enable
                set log enable
                set severity low
            end
            config max-url-param
                set status enable
                set log enable
                set severity low
            end
            config max-range-segment
                set status enable
                set log enable
                set severity high
            end
        end
    next
end
config firewall policy
    edit 1
        set name "manbas to wan"
        set uuid c8915a22-54b0-51eb-aa9f-51082e8731b6
        set srcintf "lan"
        set dstintf "wan"
        set srcaddr "all"
        set dstaddr "all"
        set action accept
        set schedule "always"
        set service "ALL"
        set fsso disable
    next
    edit 2
        set name "Pedagogy to wan"
        set uuid e61b2938-54b0-51eb-0359-b84666a66487
        set srcintf "Pedagogy"
        set dstintf "wan"
        set srcaddr "all"
        set dstaddr "all"
        set action accept
        set schedule "always"
        set service "ALL"
        set fsso disable
    next
    edit 3
        set name "Wifi to wan"
        set uuid f34f93be-54b0-51eb-7c9c-a53bbf0aa588
        set srcintf "Wifi"
        set dstintf "wan"
        set srcaddr "all"
        set dstaddr "all"
        set action accept
        set schedule "always"
        set service "ALL"
        set fsso disable
    next
    edit 4
        set name "Wan to manbas"
        set uuid 4c39597e-54b1-51eb-64f3-920800cf158c
        set srcintf "wan"
        set dstintf "lan"
        set srcaddr "all"
        set dstaddr "<?=$manbas_ip?>.254" "Clock"
        set action accept
        set schedule "always"
        set service "ALL"
        set fsso disable
    next
    edit 5
        set name "Wan to Pedagogy"
        set uuid 7672bfe6-54b1-51eb-b7cb-65d0d3d1d8f6
        set srcintf "wan"
        set dstintf "Pedagogy"
        set srcaddr "all"
        set dstaddr "<?=$pedagogy_ip?>.254"
        set action accept
        set schedule "always"
        set service "ALL"
        set fsso disable
    next
    edit 6
        set name "Wan to wifi"
        set uuid 9330245c-54b1-51eb-afad-5a548eb7dc2c
        set srcintf "wan"
        set dstintf "Wifi"
        set srcaddr "all"
        set dstaddr "<?=$wi_fi_ip?>.254"
        set action accept
        set schedule "always"
        set service "ALL"
        set fsso disable
    next
end
config firewall ssh local-key
    edit "Fortinet_SSH_RSA2048"
        set password ENC fKXqMIdcma/3hW8sWVCGVCz+PlNkizFzohNPzAE9B5lKkyYjoilKpL0KyWs967w8CAf97uxyo0UKZXtN+80HfaNygmj0eX2/UC71tKD0dXTCjH5JJd4i0zXxf5xnHa5ClIY9qHt6Gc0soLNAVJ9g6pOJ40TBbW+NivwGKWKqbF+yza4QWtn4zSBqz/41vk9vnbT7cA==
        set private-key "-----BEGIN OPENSSH PRIVATE KEY-----
b3BlbnNzaC1rZXktdjEAAAAACmFlczI1Ni1jdHIAAAAGYmNyeXB0AAAAGAAAABD6onkd9t
UQRGGIUR9kejn/AAAAEAAAAAEAAAEXAAAAB3NzaC1yc2EAAAADAQABAAABAQDjK2JfgdLW
nBMuA/zAn7JbAzSNwdI+UpqYE2/FsdqQJ4RLJN6yDElumlb1hW1thx1tbZfTky8gwmFv4M
pz5JgXeouaiPuTMMGBNIVY7Kur5npiuNBk4Law6ySAYTo+s8CJ1jTOOo6i/k4e+vILKXuh
D/jEY78dGPLmTwpZsW3PcURDitYO4XcokLM0+gx4DkGG60IGVZzn337J3g4Bl+Uq5hpgRA
i2zZyQEUJZA4q6k41S9RZ0Gpq0xJSIgvd1DSftBtArOiUmk79KqhH7FFEllxnLpRlKdbfy
OnJq2QIWdQFYT+FzvXoT6EaFSVgJldFAeBV2CN+QS0X/lk9LlwL7AAADwI/U82bGYD22qn
RfdugzLj+ozLoMe1lrkejoj2712d8AiLZDCqBsmMHn7VqG5zVH4oRNIphK8uOVljXRVMoS
7Tp9k4zRO3Hq35oxQG2DchHtL0+1C+TRgYHDiGWw2Jvr8e4K/Re7qq6AcCEFVCWKmNH4Rn
M1az1lbbCXKMg3AKD38OG40R+Q+JugWdqc4AoZqjNm+LfokqVT9BXZAoF6hWPmRSSWL2e8
4I2nXr6hM72SEv0G65hsSCb5NRneqh/+wxN1WL8CjBs4XdLOfdfLw5J0MVg/UPHu8f1XkL
yjoxaPVIKINFaiJtZnjgCrsm5FRPAT66gwhY/+xqjmR+ZXygiHlfevo0umUiHtuqyXJAdQ
GpWqxNlAE2qzaXRF+NvBmLjFN0BUl/FZWmGWVYCaQL6t/02t36NkJ/N9+63hJUsZmCpSfh
+S2ruXZD/Gwd3N9zoFZuX9tLJv1rG+6v4iejePIOrDJM5CiBhQKEqZMS7SCaWRVCBUI3R0
5RD5h098pGxtU7Pttj0qiCpenugZVkJheppVC3tLmToUSa8lVDQFuRnbUt/4sPVwd2W9sv
kjBTco0yXx7Y/kPCeOre/BBJN3s4jl38/uAw6ocxrO9M5EDd3uHaUfeRfTd41+ed1n2B8w
HSGKn6Xa/mEUKstA5SqhADpxX4EzuHGOZMU2JlKT4JElZFZQI273GIcA4TQMRrj+pUVVpG
nkVA44XKneuAtXZzSqB8tAQ8CVZ8AmrKXo27Da4NBlxdsU9PSC6Uh3pNlTjb0P7kaW0Xwo
FD5/XlLeCoyCYhriZY4bf8qjO/FmlMcV4BE12yXA2GS1kiSFL17YnyniDn0BrKBrE7TgGF
jsoqTVNL4DEOGNfLKTrdtXPL1NNfFRR34oj9Q8Q3w1RYZepQ4esOhiaQcDBTm0KJ9+Eags
gV837J2PL1wLKp4iCUy/LnbHQKzBmrQRP4jZI6XCGHevCg+7QWwsjOoNxCO5gwVTP6l3Lz
+Y2W6aRM5VVBU9vKt4kbL1Jj4hxIjD86ReLBdPgpw4PgHf95sWXFaTIyaTKRudbmnJbGt5
3UvlpVhIcnDHq4nSXTq22HBJFEe82awbxinjqMWdZScR+pz9HVi930DA8xRq9Jy/4FEor2
1v/Wzc+tbcH74yMyy9jYsuTwk6XCed1PBKamkXi+HojqrDjH+O4YUUxqKsqmPjhlgspIYB
vaU6Fdskrb1odPEvfBQJr83ZbsdKlhXTnohAyaLTHxKk0YhAGUwe4zTreN+KWNjHuDFLI1
UjGRBfLQ==
-----END OPENSSH PRIVATE KEY-----
"
        set public-key "ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQDjK2JfgdLWnBMuA/zAn7JbAzSNwdI+UpqYE2/FsdqQJ4RLJN6yDElumlb1hW1thx1tbZfTky8gwmFv4Mpz5JgXeouaiPuTMMGBNIVY7Kur5npiuNBk4Law6ySAYTo+s8CJ1jTOOo6i/k4e+vILKXuhD/jEY78dGPLmTwpZsW3PcURDitYO4XcokLM0+gx4DkGG60IGVZzn337J3g4Bl+Uq5hpgRAi2zZyQEUJZA4q6k41S9RZ0Gpq0xJSIgvd1DSftBtArOiUmk79KqhH7FFEllxnLpRlKdbfyOnJq2QIWdQFYT+FzvXoT6EaFSVgJldFAeBV2CN+QS0X/lk9LlwL7"
        set source built-in
    next
    edit "Fortinet_SSH_DSA1024"
        set password ENC su0R9Ru/VvXFtXWu70noh7Gkb//feMVVC+Lwju6UH+KzhpM9xe/iuOIJ3VLubyx2BwOIxLHN4vMc+lz0nowk71zm6mUZ4qiEyrCM6TfSmvcb+AEKY/R16rOT8/vqn5phL3ZegvRTiCnPSYFcz5Y9fdZxCpf6jfLvS6Y8lrfM3aBvGHJq2uj2yKPb97niEMwRWQSiHQ==
        set private-key "-----BEGIN OPENSSH PRIVATE KEY-----
b3BlbnNzaC1rZXktdjEAAAAACmFlczI1Ni1jdHIAAAAGYmNyeXB0AAAAGAAAABD6Lfi1eV
a6oVPs1w2QGFPdAAAAEAAAAAEAAAGxAAAAB3NzaC1kc3MAAACBAK4xEzKsdDAGqRpAkw2o
FF/zAoxjMX1JrCCPQ3HsohwexHkVph1+ZTaqIU0GyTlivaRvEGbmpvRntmm9TtOcGUIlyV
NwS2thhxgMv5L11DRsPx8O8rTvLCq/omiTU9TpWsbMw81T4BknF622XC89GFZT69jMrRrX
wDMPw3WrcpjhAAAAFQCqjgE96X9VOZ5qVEZ5FpapnR7KfwAAAIA8VuxKn1XXHFiTlq4WYs
2jfLmeAXpqwhU5zjC7EbM7ciZPxFhQyGBzkjeA1xD81D6epKpWUYbOpraMeOP8tsradTAh
VLns7qWhpJNzK6Vm1/ZS3dSvoalat0vBOW4ABOJifsDGnsCIAxJlSl1cQU8tZfuMb7O3tC
XhQOeluVVhrQAAAIACmB2+hjxFjnVu4k1uqeezQCAJBV7yaNJ9HGtmm3yd6koFMMQcPaB0
pfb3RTOUGwDZ9+fatbLXIi7U4L3Be5eIp4hWrOvS5mY3t6pd0OxJte0QlnjIVjeHJqhjzI
dKQIG0JSWMh6htSuYN2QXJ7B+gYNjSvyTJ610jMa4njSlM8gAAAeBafzodyWo23HmjIeBF
LEgFOSU+2CDdeOFVoHkQAKYKpDJ2PJ6CMuDCp84nKlGIbjUofocQxD2ROAKPXVxi5uFzz5
lWZTC9bBdGyrhFP4tdjMKsVvbIN80y6nzUoU/sPJMTV4BhJVKGaaZ5Sgnikuh9bCCxkcmB
gyYJAAbLD8x2xwfE2Eqa/D8gth8ljYCoBeU4QSiSYtMCPfPvN3CtnUZf8uXF7SS/TUZqq8
NW1F1xc9X06OjPQQxTNddqojBPDv+S+0wp3IUdXbASZgVMDba9b2GkpGcYcZ0vxV3ztSCv
i+F85AGv/aDZ/EyhCpt+CUzMu+UDl/6tpwV1M0ABXJ9I7xeNUPbizHjTbyujj4d9I//Ef0
n/fZlT1Wv5Il7sUgfCDMllnlEi06+2XfDV/j85ZwmyPEjBF90/2ij7XmOENxdXFrPjC8R3
c6vey0KKXljBcVXW79RgAksOXgXH4+Sz/MDOpr6VlTvkOiHhRY/aBOBO9IS0qnm95UAq0B
ymE8u+wxtWUSyKriSwPVktokIaN+deyCEbQwd4bGT5vMkgTcewLhRDbmBKp28+znTjGcsr
IEh0dIwD762gtilh26rsiFu/u038bgkug2vrfmPgUN0c6VsUypYoCFCxtRhiVxs=
-----END OPENSSH PRIVATE KEY-----
"
        set public-key "ssh-dss AAAAB3NzaC1kc3MAAACBAK4xEzKsdDAGqRpAkw2oFF/zAoxjMX1JrCCPQ3HsohwexHkVph1+ZTaqIU0GyTlivaRvEGbmpvRntmm9TtOcGUIlyVNwS2thhxgMv5L11DRsPx8O8rTvLCq/omiTU9TpWsbMw81T4BknF622XC89GFZT69jMrRrXwDMPw3WrcpjhAAAAFQCqjgE96X9VOZ5qVEZ5FpapnR7KfwAAAIA8VuxKn1XXHFiTlq4WYs2jfLmeAXpqwhU5zjC7EbM7ciZPxFhQyGBzkjeA1xD81D6epKpWUYbOpraMeOP8tsradTAhVLns7qWhpJNzK6Vm1/ZS3dSvoalat0vBOW4ABOJifsDGnsCIAxJlSl1cQU8tZfuMb7O3tCXhQOeluVVhrQAAAIACmB2+hjxFjnVu4k1uqeezQCAJBV7yaNJ9HGtmm3yd6koFMMQcPaB0pfb3RTOUGwDZ9+fatbLXIi7U4L3Be5eIp4hWrOvS5mY3t6pd0OxJte0QlnjIVjeHJqhjzIdKQIG0JSWMh6htSuYN2QXJ7B+gYNjSvyTJ610jMa4njSlM8g=="
        set source built-in
    next
    edit "Fortinet_SSH_ECDSA256"
        set password ENC 5Vy4CPsac/BX8LKPTDhh6meSNfcvclrIZYPWf8mhgglkOT5pVkkgrTUR7tfmMEYl8/Ug0meHb66jTcIeUzbXrfllqi0UZhsPS3rCr3P7nd7TRjQ3wmevFiQlWhp4IoHLzj00Ww1N3M8vB31RV4R6jv9MUIzPeDNoJ6+yRGEKOrwj/1PlTvNNUMmUhC0SXXV+GSy9lg==
        set private-key "-----BEGIN OPENSSH PRIVATE KEY-----
b3BlbnNzaC1rZXktdjEAAAAACmFlczI1Ni1jdHIAAAAGYmNyeXB0AAAAGAAAABBjejBtXp
eY4KDBlizqF0kLAAAAEAAAAAEAAABoAAAAE2VjZHNhLXNoYTItbmlzdHAyNTYAAAAIbmlz
dHAyNTYAAABBBClMIqxJu0y00/vGMwu1VPIy0wGty/sViwrMuFeiPBR+YmzD/EeAtINlH6
cdZyRbP62x+JmsC6ZX1wuwLatCkSEAAACggdMsnUi2Fw4HnxvC20GfIaSly/I5q5vaNSsT
JQfnuBOwk85P+0rihT6TzWGOQdj/lUh/4VzLgE7pa+i/IuY7Ylz/z4WdhVX7RGbv6zNCz9
cXncVN1s+6ufeFcPfRQMw+AB0iem0ULJ8DQptJ5g4WsXffDut9QLPQCs59muk9Dw60U4ln
HbrDICpdsVFL9OM+WBC0CcmisolZhzFS5avMOQ==
-----END OPENSSH PRIVATE KEY-----
"
        set public-key "ecdsa-sha2-nistp256 AAAAE2VjZHNhLXNoYTItbmlzdHAyNTYAAAAIbmlzdHAyNTYAAABBBClMIqxJu0y00/vGMwu1VPIy0wGty/sViwrMuFeiPBR+YmzD/EeAtINlH6cdZyRbP62x+JmsC6ZX1wuwLatCkSE="
        set source built-in
    next
    edit "Fortinet_SSH_ECDSA384"
        set password ENC 17V8HBy5M5vxT7zkkGS/AfjadA/btijK+JxxAGZaUrqI6PoVWPy9ogBoZOpy2RHNrIJgZCd8mge9sjUFCX+Gl+MISPS4ljGL84EcK18qIP74ipkeLgtAC2ebrLwcnAS7sRkHNctMs8QPSz9XKG9aw7bKJqVJ7tfvMBx2bhTNq7dYPO9VD1jxWeo25UeHFjPFavGvvw==
        set private-key "-----BEGIN OPENSSH PRIVATE KEY-----
b3BlbnNzaC1rZXktdjEAAAAACmFlczI1Ni1jdHIAAAAGYmNyeXB0AAAAGAAAABAJ6v0rFb
0G33KmBIx+T0KnAAAAEAAAAAEAAACIAAAAE2VjZHNhLXNoYTItbmlzdHAzODQAAAAIbmlz
dHAzODQAAABhBKy4Vd0OQgBNgPGumVXmI9a42ruoXldRVxqiRrR3zY33bgUFHnpSHKelwq
SPK+Vbdzavm/+Q3d4oA/rIw+lknvj6QHbizrveuZBnqbxko9wxdW0LVXuvDfn1HFRJ/tVq
NgAAANCsldS0+2FMkNATo5XkgolYfvO9DO76/mDyZTSY6XCeC6ybh0XMB3Fte2MTMMrhI0
w8FElLMcZ5Rmnx23gQRrbEfjE9DnvGBGzQLKhKXeq4fLjU7tGFzQ+13hhZuXfljXkSUC++
zP+PapUgs+zjMilYrRKmfjxR1bpCB1Awc5tuOq5Nkr08l1p7SopodsZWBIbsc5bgRiLLU6
94xj1yfTusCWpzuPewibDKuD7QsIWGPwpNgkRFKDUGWTVqb0gQXChl9515os50Pv9M7zAk
5HUa
-----END OPENSSH PRIVATE KEY-----
"
        set public-key "ecdsa-sha2-nistp384 AAAAE2VjZHNhLXNoYTItbmlzdHAzODQAAAAIbmlzdHAzODQAAABhBKy4Vd0OQgBNgPGumVXmI9a42ruoXldRVxqiRrR3zY33bgUFHnpSHKelwqSPK+Vbdzavm/+Q3d4oA/rIw+lknvj6QHbizrveuZBnqbxko9wxdW0LVXuvDfn1HFRJ/tVqNg=="
        set source built-in
    next
    edit "Fortinet_SSH_ECDSA521"
        set password ENC 3ZH4SqBs/6VMVEf9OFbWTkz8vXQ0nHRW4jIOoesXdlDLTQlOom/reGV8ftnccfT1by0C59CBY9oLQbuR122jfKCtP5qignb5qdtkXH3EV1u13QOE3IK+AoDKUDSFvTybu/rPXTYVTjhfDEE2y44WuQXx3+lZ3qBsRiTgyxVq+ppprX5ULWCaRw5mJZZz/0Yp5oceOg==
        set private-key "-----BEGIN OPENSSH PRIVATE KEY-----
b3BlbnNzaC1rZXktdjEAAAAACmFlczI1Ni1jdHIAAAAGYmNyeXB0AAAAGAAAABCNStmj8q
sXxHmTKj1vwlulAAAAEAAAAAEAAACsAAAAE2VjZHNhLXNoYTItbmlzdHA1MjEAAAAIbmlz
dHA1MjEAAACFBAFAjrRnf3TO/zgm1qD+PWKAHeZ/HDP/tWLTjusx2zxSp1cKm5X3sFTjnx
YHQvqwYy8sAWoO/v7H9BNkg9KKN/gXuwEsVcJN6TfiVk2+ZEZ1O89VsC7OBBS8uDV4BrN5
lenck5ZLinmNNLk+Vq1ZCKTWtlIa5+AtcfSE1my8gcPCQIk1aAAAAQCxkadev4J977nnqp
YB16hmwsRbzmUiMToZsKaWYN79bGUEl+MJnYI5bg26HU92GGoN+GAzY2jPRa41kBg4Gd0e
hTpuoV2WHUnpC+n64kyV8YGjL51IE1GLtlqRxxKCXGBw7GHrRbZdlKvKR3cqnppPZ8TomG
irjFgMLf6agBfCAQa/AbB6ouo4WDterIUcakDRItYTBCMuXPMlA6YLX191o+Q5/Fuf42oo
Y02FqzXw+hFpUvr41+7mzUJPpWMNFugyTOhZzuez2+kio4q51IqRNtO4WWng+edJ/sjrvK
vS3GK/p5/NJ2UN0Ng485JIsm/7FENlF24P9Px4h/bTLpWX
-----END OPENSSH PRIVATE KEY-----
"
        set public-key "ecdsa-sha2-nistp521 AAAAE2VjZHNhLXNoYTItbmlzdHA1MjEAAAAIbmlzdHA1MjEAAACFBAFAjrRnf3TO/zgm1qD+PWKAHeZ/HDP/tWLTjusx2zxSp1cKm5X3sFTjnxYHQvqwYy8sAWoO/v7H9BNkg9KKN/gXuwEsVcJN6TfiVk2+ZEZ1O89VsC7OBBS8uDV4BrN5lenck5ZLinmNNLk+Vq1ZCKTWtlIa5+AtcfSE1my8gcPCQIk1aA=="
        set source built-in
    next
    edit "Fortinet_SSH_ED25519"
        set password ENC vD+3UrCMsUtvgT4aOybkqA7J67vPIR8pukAXrnYhkwIHpmJD7FbdIUMh4FFxefqHLMXqnh5FRcNis3C/wArDy8jhVwbR0pBcNeocOe3Ny4rar1s0JRmeGOEaaH8a+z1PP5L9HqDDG/YjGLxbjQQwKCZUjXLGAuu+TX0K0AbEH4KP+pVHVhvlQm8tbECw3Eu84+Z5GQ==
        set private-key "-----BEGIN OPENSSH PRIVATE KEY-----
b3BlbnNzaC1rZXktdjEAAAAACmFlczI1Ni1jdHIAAAAGYmNyeXB0AAAAGAAAABBD5ONbH0
po00oXX3q+DMlaAAAAEAAAAAEAAAAzAAAAC3NzaC1lZDI1NTE5AAAAIP7BtmIz3OA7NUE+
npAIRqo+f1OYBtpUdggYMO0KGMRxAAAAkBfwflxSxS14ZaQRrpzNKf255GWx4InZpT1CZy
WBSAjG58xeIHcVGt7VJt6Q6wnUe019fADWKu5mbHOBczg/68eQ2bT0RRngqCECcb+efFnr
sv//5adu71+VezWIAdPcnoTzMBmCpxgcGJ35fSvoDiUJVMJ5Ogmzi26kUmtdypR1Vm7mO2
8xsOhz42yxM+rtPQ==
-----END OPENSSH PRIVATE KEY-----
"
        set public-key "ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIP7BtmIz3OA7NUE+npAIRqo+f1OYBtpUdggYMO0KGMRx"
        set source built-in
    next
end
config firewall ssh local-ca
    edit "Fortinet_SSH_CA"
        set password ENC 2yBcG+ZxxXo0e+rQOAA7IvWo0sgY9gjpykxlGHVtfQRfXnmRHcrEcvysChIfYxETgMQCeKWAteuxggzk6Mf1FVnM+qSE7GdRSCgoGxejmOXyCJL3AjsqM2ls3RWeo+ZjgdWp70V4HZpt60gF+Urg/jAbgMl1a/F1oentJZaPfDVtQcA+TP/9rXckindFB2PhnF2fnA==
        set private-key "-----BEGIN OPENSSH PRIVATE KEY-----
b3BlbnNzaC1rZXktdjEAAAAACmFlczI1Ni1jdHIAAAAGYmNyeXB0AAAAGAAAABARgwiVef
vzB8989KgW3o72AAAAEAAAAAEAAAEXAAAAB3NzaC1yc2EAAAADAQABAAABAQDRGO1dFnZB
IsPqsayMXFziCYeVurVYBlTImu2iH1F4YB+wZ08kA0Y/T1mZP4/R/AY5GBtEXrlfO1bWPo
yVux3bclnv6JqkWSkMEiblSSXrRBMRRCCbVeciHWofLHwSMYEaNAE+P/mQL5B+bFKvIs9z
5aOg7wFybiOXjBRb9rkSVd4nlOBS4CfZvpv1AcBziVpy6c+6c7PPVWQrlOpswteZK8CG2C
5ucOXSke21UQm6oVuf4mDeivjn/ZrPXACz4kZ/Y8hH7hbDCVyNvy28V3xwqtwPHRxErYP0
3rHOL32yu/xjm7i6709T5biVertxnjMG0qyHvxwbPGFU04jo1LrFAAADwCTCMPsfu5xm90
mkRrc4Qp5QA0gW6qkqPoCeZksF5OOJ6dM7tt8947yFfKuE1KJkFB0Jgz9Qei4aUVpIqoGc
KuZ7XjnzzeFh197vZNDtgOC6qBX8qMMdNPn9jrEe9ScRKek46vk5c/hi3W7aLK7yptpZRa
DMKk/K5Ww5S8gZXbf5+4SCQDJab+jzaptkE6s1xNku7LeQBI9/eeFxqi89QLU/r6rLLm0w
sQhYxfFg6Kp9PTetovmlwJ5aePk475t+R1i1dS8OrMBnmErZibLGoJlE0s9w+EWhh1w+sP
121SrOt/fDuCaUVyHNqwwPz5OIUKCgSAoAFJ6LqSnvdhtd/Xbxnf0rW0zduBDU0gavmnuU
LlViHVwb/9AnZ6Feg50ELFflEPculz1fOMpuUFSYOM17zl/o2pp0lGrXsbW50H645haNZU
8BCHPKY1DHC0K2drIOWJVmlzgPYRYKdq1dxh0Inca66zDF/GgVehkz+THsq1j1Usrt1h6d
Rz6io2h7PoVOEVmZ6t2P4QKVhHnDK0noUmOpFtQMbs9GMnqEmUcpCUXcgJeJOPIyDwURkN
k8Z3aVpzzQ/FejslLmHtXlnmzZX529nXVBeN+jnbi8WQ3dGam2tSBSodeaLwsqZhHetcqT
c0YRUuaaaoFQe5gKdYIteR6qx1RrIpL116INw+5e/FiLPy2znlVFxLT88Fz0nusTaWtHnF
BpJDoSpXO+TkzDL52rmFRf1l7ycDCagAU5Jdyl2xGpfA6cN/FeYIkv+UH5k5/gjyDWX3FT
nqqB83+V0cYHPjMPZOwfKozqjBCDkDplAcRmk2ItB+yFKhxyOEb16noeb7xKg7rnAemeW4
WdBAAc3m13ZjaCBGIGS5tN7mfHJJEmRtrMwr3salkcmZHL8GxznDn2V72ezIeqfCpnGijV
MA/lZA3r9TNNtfSD1qOIEyhSUmpcPv5vdzGcrUV/+ZaUgg3oQbHnbDf1t4wZ1FULLczQI4
YWIvcIntvmIk2PBSCxkBh/nEHAkuIf0duxQKWvDLsl5W059zAGyQvTwXKorYpVuKcd5NeC
+4uSZ5/CpZFpT9bvjla9E7/MwFah8NDy9JU95dfoHh62h9MWAKSyqBkWzyE2fbmR6QlHZl
cxDw/9Xd1pccuUlG4gayO99Y30Q1QaRX4+g7iDHAUHq5cSoA/JoODzE/LZBasCWlVZHsFA
4aRZlEbMmdBxi6aXLJ5b8aUw1gxI9Vgy84wn8v3vdi6t/+O7uPFI3G7pO8c7fpg0eMqgxj
WC4PmlSg==
-----END OPENSSH PRIVATE KEY-----
"
        set public-key "ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQDRGO1dFnZBIsPqsayMXFziCYeVurVYBlTImu2iH1F4YB+wZ08kA0Y/T1mZP4/R/AY5GBtEXrlfO1bWPoyVux3bclnv6JqkWSkMEiblSSXrRBMRRCCbVeciHWofLHwSMYEaNAE+P/mQL5B+bFKvIs9z5aOg7wFybiOXjBRb9rkSVd4nlOBS4CfZvpv1AcBziVpy6c+6c7PPVWQrlOpswteZK8CG2C5ucOXSke21UQm6oVuf4mDeivjn/ZrPXACz4kZ/Y8hH7hbDCVyNvy28V3xwqtwPHRxErYP03rHOL32yu/xjm7i6709T5biVertxnjMG0qyHvxwbPGFU04jo1LrF"
        set source built-in
    next
    edit "Fortinet_SSH_CA_Untrusted"
        set password ENC 92R87VCv0yeeAyUkbMyPmZp3OyZXR3vn9/3Jp2ZTOcg+Zo47Gj9QSOEO2KsN7KTZaww0QxJMiqExQybSX3iPtTeKeV/II+4B3GSaeDnRBb0nbi/vPT00YdaGtvpPFECT3ng7CebiP39lAyAyi2GNF1xg9f8+UoTV5lTqHE1uOJ5CN/SI/zn7B+pb5ck2fgeAuHrrlQ==
        set private-key "-----BEGIN OPENSSH PRIVATE KEY-----
b3BlbnNzaC1rZXktdjEAAAAACmFlczI1Ni1jdHIAAAAGYmNyeXB0AAAAGAAAABAz03wCD+
NHV3Nn5K1xo09PAAAAEAAAAAEAAAEXAAAAB3NzaC1yc2EAAAADAQABAAABAQDgHd86XaEV
KSY9aPmPjsxkums7s8Vs1JPupHymRkUAAEeLIT/FcSFcBemg7il6eiPIb3kuo6+gdFAel6
uJZyiNfRB7aYKo0m+bho3p7CyuLpEr1f8tJa9VglG6JF5fctW+T+GlHFiJcF/a43KCRAgq
EtaXd65fMYQX0QcOC+ePhXb2emIyluwZL8X4Awyg1jODPsP/WUT6GejPqnqvR2z4yEkq+L
SRddGBPgkFMWwRD81OvgXJmYXgJ4X1HeB91YQDeYNjDQ7n99253J8WY+5wNOBlE/nIY9ZF
rdJHAO7oq84JrkCUNdTOvkgxW4b+AMHkPUEyAPvMLWvK0ZQ54DKtAAADwClq2VINhMwcvv
qDbqrBWQMsjW1l6b8iZT+qp1QgKb0Czvsp7CWMzdHUFQjQniIJs1/Dd/uI7zQNbEUJy1hj
RMBZseKYeXeqjnAImffw4+hA/LIVYkMNYYTSuyS8AGu99H3l9rroYGyEDf7JDrM75H6dzZ
2REkB/N4w0RT1MR+QIbRzVDFGAVgSTV5M2Jao0rXdkGFN61NN9e9c3xjKH8z0Fa7AH5qNH
zOiqcc9cD+23E/Fr/0V0sJv5b/JsmS1/NbJHtiK5qhelKmJk8B1sHbgWtCSpOYU3T9WAuY
9IIQI3Js/hW0j8sKecfrV9uPswrLxXJxyXofi9nNgAxD1J0/+Kdi3wNzMVN8EU/dU8jRn1
kRjIee4cdd8O3B5pUsDB4rItjd3N2Xt88CxmZm9Dc1zGe0mDD6pXaXO/5/msVGJvHEHvMh
5oz0B3MfJJ8MMlEr8Kxj8yfj2naBeykUfs6nNy1EkRyEMaJ+jwdY2shZWiBMT/LxaHLQbV
N3QnCmEVdAcrtmbYYXvuxSPHewEDLIO9qF1Z4VuwPTct+gU+QDhCYYAM7TIeB16+zVdxBb
VaTSlFJQhPvkpp5B1vbHye4Djpa2z3K6yz8bfHVYW6g1U3LY9bUNa6VQ10WKAGZPiPh0hw
85dkIS1+1sBNZYJcdrZgR2PnIsgSS4u6eNzR6H6PL0DtUgpqZHLvPRi/wxoOBrwyc3CJX0
fbIkn+331nnhiJuC9D9Wt1iFgS1sWr7aTSX8S28YNR5aHH0oFwfd4egQGzDCqS2ZUoVqys
OMqzJmOywumQcgVdbzptxO5Q4l9Hb+42jbfIZkdJjZxmnG9/oa9tBlU2yIgJEtgn1xBrU2
/nKKkSsLFf8sViwleyKs2HJeV7+0MylGBzk8tA+VAiUImV8mLDXEInnFKNjMZ/64J8gSgZ
yIXdopxBIJnuw+MiMqtTYCQNwzXTt8r4bPS0o44avv53GrUGjO+Anc8cOw63bzHSLcPLrn
YVy8D8J9hS2x/+rpYIyvrCY4BkLpT2mwXCHrFCZ/Ca6zKzXpRVDcPdM4Vh39PVL/Vl/Vjs
l7/coPXelekwdiadZPxBK/+JFAgJxRHMtYcoW4Osghqj9tDlQSNs6TrqUKaqtVoDnDxdWe
USt3HcBq2ge+Sl9oSShk6qIwlzIILW1KUesUSuzT+A/f2NeadEEEpW/gxvakDdo4yypRqd
+EWjOq3mOkLYQ9wY40oO7AYm/WO8BOpoKCdmgU1rRu7ndGCsRCdmWhcibUCskDaLfyrMXg
83rvDYsQ==
-----END OPENSSH PRIVATE KEY-----
"
        set public-key "ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQDgHd86XaEVKSY9aPmPjsxkums7s8Vs1JPupHymRkUAAEeLIT/FcSFcBemg7il6eiPIb3kuo6+gdFAel6uJZyiNfRB7aYKo0m+bho3p7CyuLpEr1f8tJa9VglG6JF5fctW+T+GlHFiJcF/a43KCRAgqEtaXd65fMYQX0QcOC+ePhXb2emIyluwZL8X4Awyg1jODPsP/WUT6GejPqnqvR2z4yEkq+LSRddGBPgkFMWwRD81OvgXJmYXgJ4X1HeB91YQDeYNjDQ7n99253J8WY+5wNOBlE/nIY9ZFrdJHAO7oq84JrkCUNdTOvkgxW4b+AMHkPUEyAPvMLWvK0ZQ54DKt"
        set source built-in
    next
end
config firewall ssh setting
    set caname "Fortinet_SSH_CA"
    set untrusted-caname "Fortinet_SSH_CA_Untrusted"
    set hostkey-rsa2048 "Fortinet_SSH_RSA2048"
    set hostkey-dsa1024 "Fortinet_SSH_DSA1024"
    set hostkey-ecdsa256 "Fortinet_SSH_ECDSA256"
    set hostkey-ecdsa384 "Fortinet_SSH_ECDSA384"
    set hostkey-ecdsa521 "Fortinet_SSH_ECDSA521"
    set hostkey-ed25519 "Fortinet_SSH_ED25519"
end
config switch-controller security-policy 802-1X
    edit "802-1X-policy-default"
        set user-group "SSO_Guest_Users"
        set mac-auth-bypass disable
        set open-auth disable
        set eap-passthru enable
        set guest-vlan disable
        set auth-fail-vlan disable
        set radius-timeout-overwrite disable
    next
end
config switch-controller lldp-profile
    edit "default"
        set med-tlvs inventory-management network-policy
        set auto-isl disable
        config med-network-policy
            edit "voice"
            next
            edit "voice-signaling"
            next
            edit "guest-voice"
            next
            edit "guest-voice-signaling"
            next
            edit "softphone-voice"
            next
            edit "video-conferencing"
            next
            edit "streaming-video"
            next
            edit "video-signaling"
            next
        end
    next
    edit "default-auto-isl"
    next
end
config switch-controller qos dot1p-map
    edit "voice-dot1p"
        set priority-0 queue-4
        set priority-1 queue-4
        set priority-2 queue-3
        set priority-3 queue-2
        set priority-4 queue-3
        set priority-5 queue-1
        set priority-6 queue-2
        set priority-7 queue-2
    next
end
config switch-controller qos ip-dscp-map
    edit "voice-dscp"
        config map
            edit "1"
                set cos-queue 1
                set value 46
            next
            edit "2"
                set cos-queue 2
                set value 24,26,48,56
            next
            edit "5"
                set cos-queue 3
                set value 34
            next
        end
    next
end
config switch-controller qos queue-policy
    edit "default"
        set schedule round-robin
        config cos-queue
            edit "queue-0"
            next
            edit "queue-1"
            next
            edit "queue-2"
            next
            edit "queue-3"
            next
            edit "queue-4"
            next
            edit "queue-5"
            next
            edit "queue-6"
            next
            edit "queue-7"
            next
        end
    next
    edit "voice-egress"
        set schedule weighted
        config cos-queue
            edit "queue-0"
            next
            edit "queue-1"
                set weight 0
            next
            edit "queue-2"
                set weight 6
            next
            edit "queue-3"
                set weight 37
            next
            edit "queue-4"
                set weight 12
            next
            edit "queue-5"
            next
            edit "queue-6"
            next
            edit "queue-7"
            next
        end
    next
end
config switch-controller qos qos-policy
    edit "default"
    next
    edit "voice-qos"
        set trust-dot1p-map "voice-dot1p"
        set trust-ip-dscp-map "voice-dscp"
        set queue-policy "voice-egress"
    next
end
config switch-controller switch-profile
    edit "default"
    next
end
config endpoint-control profile
    edit "default"
        config forticlient-winmac-settings
        end
        config forticlient-android-settings
        end
        config forticlient-ios-settings
        end
    next
end
config wireless-controller wids-profile
    edit "default"
        set comment "Default WIDS profile."
        set ap-scan enable
        set wireless-bridge enable
        set deauth-broadcast enable
        set null-ssid-probe-resp enable
        set long-duration-attack enable
        set invalid-mac-oui enable
        set weak-wep-iv enable
        set auth-frame-flood enable
        set assoc-frame-flood enable
        set spoofed-deauth enable
        set asleap-attack enable
        set eapol-start-flood enable
        set eapol-logoff-flood enable
        set eapol-succ-flood enable
        set eapol-fail-flood enable
        set eapol-pre-succ-flood enable
        set eapol-pre-fail-flood enable
    next
    edit "default-wids-apscan-enabled"
        set ap-scan enable
    next
end
config wireless-controller wtp-profile
    edit "FAPU323EV-default"
        config platform
            set type U323EV
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n
        end
        config radio-2
            set band 802.11ac
        end
    next
    edit "FAPU321EV-default"
        config platform
            set type U321EV
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n
        end
        config radio-2
            set band 802.11ac
        end
    next
    edit "FAPU24JEV-default"
        config platform
            set type U24JEV
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n
        end
        config radio-2
            set band 802.11ac
        end
    next
    edit "FAPU223EV-default"
        config platform
            set type U223EV
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n
        end
        config radio-2
            set band 802.11ac
        end
    next
    edit "FAPU221EV-default"
        config platform
            set type U221EV
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n
        end
        config radio-2
            set band 802.11ac
        end
    next
    edit "FAPU423E-default"
        config platform
            set type U423E
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n
        end
        config radio-2
            set band 802.11ac
        end
    next
    edit "FAPU422EV-default"
        config platform
            set type U422EV
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n
        end
        config radio-2
            set band 802.11ac
        end
    next
    edit "FAPU421E-default"
        config platform
            set type U421E
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n
        end
        config radio-2
            set band 802.11ac
        end
    next
    edit "FAPS223E-default"
        config platform
            set type S223E
        end
        set handoff-sta-thresh 55
        config radio-1
            set band 802.11n,g-only
        end
        config radio-2
            set band 802.11ac
        end
    next
    edit "FAPS221E-default"
        config platform
            set type S221E
        end
        set handoff-sta-thresh 55
        config radio-1
            set band 802.11n,g-only
        end
        config radio-2
            set band 802.11ac
        end
    next
    edit "FAP224E-default"
        config platform
            set type 224E
        end
        set handoff-sta-thresh 55
        config radio-1
            set band 802.11n,g-only
        end
        config radio-2
            set band 802.11ac
        end
    next
    edit "FAP223E-default"
        config platform
            set type 223E
        end
        set handoff-sta-thresh 55
        config radio-1
            set band 802.11n,g-only
        end
        config radio-2
            set band 802.11ac
        end
    next
    edit "FAP222E-default"
        config platform
            set type 222E
        end
        set handoff-sta-thresh 55
        config radio-1
            set band 802.11n,g-only
        end
        config radio-2
            set band 802.11ac
        end
    next
    edit "FAP221E-default"
        config platform
            set type 221E
        end
        set handoff-sta-thresh 55
        config radio-1
            set band 802.11n,g-only
        end
        config radio-2
            set band 802.11ac
        end
    next
    edit "FAP423E-default"
        config platform
            set type 423E
        end
        set handoff-sta-thresh 55
        config radio-1
            set band 802.11n,g-only
        end
        config radio-2
            set band 802.11ac
        end
    next
    edit "FAP421E-default"
        config platform
            set type 421E
        end
        set handoff-sta-thresh 55
        config radio-1
            set band 802.11n,g-only
        end
        config radio-2
            set band 802.11ac
        end
    next
    edit "FAPS423E-default"
        config platform
            set type S423E
        end
        set handoff-sta-thresh 55
        config radio-1
            set band 802.11n,g-only
        end
        config radio-2
            set band 802.11ac
        end
    next
    edit "FAPS422E-default"
        config platform
            set type S422E
        end
        set handoff-sta-thresh 55
        config radio-1
            set band 802.11n,g-only
        end
        config radio-2
            set band 802.11ac
        end
    next
    edit "FAPS421E-default"
        config platform
            set type S421E
        end
        set handoff-sta-thresh 55
        config radio-1
            set band 802.11n,g-only
        end
        config radio-2
            set band 802.11ac
        end
    next
    edit "FAPS323CR-default"
        config platform
            set type S323CR
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n,g-only
        end
        config radio-2
            set band 802.11ac
        end
    next
    edit "FAPS322CR-default"
        config platform
            set type S322CR
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n,g-only
        end
        config radio-2
            set band 802.11ac
        end
    next
    edit "FAPS321CR-default"
        config platform
            set type S321CR
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n,g-only
        end
        config radio-2
            set band 802.11ac
        end
    next
    edit "FAPS313C-default"
        config platform
            set type S313C
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11ac
        end
    next
    edit "FAPS311C-default"
        config platform
            set type S311C
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11ac
        end
    next
    edit "FAPS323C-default"
        config platform
            set type S323C
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n,g-only
        end
        config radio-2
            set band 802.11ac
        end
    next
    edit "FAPS322C-default"
        config platform
            set type S322C
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n,g-only
        end
        config radio-2
            set band 802.11ac
        end
    next
    edit "FAPS321C-default"
        config platform
            set type S321C
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n,g-only
        end
        config radio-2
            set band 802.11ac
        end
    next
    edit "FAP321C-default"
        config platform
            set type 321C
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n,g-only
        end
        config radio-2
            set band 802.11ac
        end
    next
    edit "FAP223C-default"
        config platform
            set type 223C
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n,g-only
        end
        config radio-2
            set band 802.11ac
        end
    next
    edit "FAP112D-default"
        config platform
            set type 112D
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n,g-only
        end
    next
    edit "FAP24D-default"
        config platform
            set type 24D
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n,g-only
        end
    next
    edit "FAP21D-default"
        config platform
            set type 21D
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n,g-only
        end
    next
    edit "FK214B-default"
        config platform
            set type 214B
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n,g-only
        end
    next
    edit "FAP224D-default"
        config platform
            set type 224D
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n-5G
        end
        config radio-2
            set band 802.11n,g-only
        end
    next
    edit "FAP222C-default"
        config platform
            set type 222C
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n,g-only
        end
        config radio-2
            set band 802.11ac
        end
    next
    edit "FAP25D-default"
        config platform
            set type 25D
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n,g-only
        end
    next
    edit "FAP221C-default"
        config platform
            set type 221C
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n,g-only
        end
        config radio-2
            set band 802.11ac
        end
    next
    edit "FAP320C-default"
        config platform
            set type 320C
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n,g-only
        end
        config radio-2
            set band 802.11ac
        end
    next
    edit "FAP28C-default"
        config platform
            set type 28C
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n,g-only
        end
    next
    edit "FAP223B-default"
        config platform
            set type 223B
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n-5G
        end
        config radio-2
            set band 802.11n,g-only
        end
    next
    edit "FAP14C-default"
        config platform
            set type 14C
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n,g-only
        end
    next
    edit "FAP11C-default"
        config platform
            set type 11C
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n,g-only
        end
    next
    edit "FAP320B-default"
        config platform
            set type 320B
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n-5G
        end
        config radio-2
            set band 802.11n,g-only
        end
    next
    edit "FAP112B-default"
        config platform
            set type 112B
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n,g-only
        end
    next
    edit "FAP222B-default"
        config platform
            set type 222B
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n,g-only
        end
        config radio-2
            set band 802.11n-5G
        end
    next
    edit "FAP210B-default"
        config platform
            set type 210B
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n,g-only
        end
    next
    edit "FAP220B-default"
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n-5G
        end
        config radio-2
            set band 802.11n,g-only
        end
    next
    edit "AP-11N-default"
        config platform
            set type AP-11N
        end
        set handoff-sta-thresh 30
        config radio-1
            set band 802.11n,g-only
        end
    next
end
config wireless-controller utm-profile
    edit "wifi-default"
        set comment "Default configuration for offloading WiFi traffic."
        set ips-sensor "wifi-default"
        set application-list "wifi-default"
        set antivirus-profile "wifi-default"
        set webfilter-profile "wifi-default"
    next
end
config log memory setting
    set status enable
end
config log null-device setting
    set status disable
end
config router rip
    config redistribute "connected"
    end
    config redistribute "static"
    end
    config redistribute "ospf"
    end
    config redistribute "bgp"
    end
    config redistribute "isis"
    end
end
config router ripng
    config redistribute "connected"
    end
    config redistribute "static"
    end
    config redistribute "ospf"
    end
    config redistribute "bgp"
    end
    config redistribute "isis"
    end
end
config router static
    edit 1
        set gateway <?=$wan_ip_static?> 
        set device "wan"
    next
end
config router ospf
    config redistribute "connected"
    end
    config redistribute "static"
    end
    config redistribute "rip"
    end
    config redistribute "bgp"
    end
    config redistribute "isis"
    end
end
config router ospf6
    config redistribute "connected"
    end
    config redistribute "static"
    end
    config redistribute "rip"
    end
    config redistribute "bgp"
    end
    config redistribute "isis"
    end
end
config router bgp
    config redistribute "connected"
    end
    config redistribute "rip"
    end
    config redistribute "ospf"
    end
    config redistribute "static"
    end
    config redistribute "isis"
    end
    config redistribute6 "connected"
    end
    config redistribute6 "rip"
    end
    config redistribute6 "ospf"
    end
    config redistribute6 "static"
    end
    config redistribute6 "isis"
    end
end
config router isis
    config redistribute "connected"
    end
    config redistribute "rip"
    end
    config redistribute "ospf"
    end
    config redistribute "bgp"
    end
    config redistribute "static"
    end
    config redistribute6 "connected"
    end
    config redistribute6 "rip"
    end
    config redistribute6 "ospf"
    end
    config redistribute6 "bgp"
    end
    config redistribute6 "static"
    end
end
config router multicast
end

var sitearr = new Array('yourdailylinks.com','donandmurph.com','allzapping.com','razak.afixiindia.com','google.com','http://','hotmail.com','http://cvbhcvb');
var idarr = new Array('56','64','65','66','68','69','70','71');
		var referer = document.referrer;
                        var rExp = /^(\s?http:\/\/)?(www\.)?([a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+)(.*)\/?/gi;
                        var referer = referer.replace(rExp, '$3');
                        var sindex = -1;
                        for(i = 0; i < sitearr.length; i++){
                                if(sitearr[i] == referer){
                                        sindex = i;
                                        break;
                                }
                        }
                        if(sindex != -1){
                                myimage = new Image();
                                myimage.src = 'index.php?page=partner&choice=track_in&referer='+document.referrer+'&user_id=' + idarr[sindex];
                        }
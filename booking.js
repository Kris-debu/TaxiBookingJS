function getData(dataSource, divID, nm, ph, pusub, pustnm,pustnum,puuni,pudate,putime,dfsub,dfstnm,dfstnum){
    if(xhr){
        var obj = document.getElementById(divID);
        var mainrequest = "name="+encodeURIComponent(nm)
		+"&phone="+encodeURIComponent(ph)
		+"&pickupSuburb="+encodeURIComponent(pusub)
		+"&pickupStreetName="+encodeURIComponent(pustnm)
		+"&pickupStreetNumber="+encodeURIComponent(pustnum)
		+"&pickupUnitNumber="+encodeURIComponent(puuni)
		+"&pickupDate="+encodeURIComponent(pudate)
        +"&pickupTime="+encodeURIComponent(putime)
		+"&dropoffSuburb="+encodeURIComponent(dfsub)
		+"&dropoffStreetName="+encodeURIComponent(dfstnm)
		+"&dropoffStreetNumber="+encodeURIComponent(dfstnum);

        xhr.open("POST", dataSource, true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function(){
            if(xhr.readyState== 4 && xhr.status == 200){ //Checking for success
                obj.innerHTML = xhr.responseText;
            }
        }
        xhr.send(mainrequest);
    }
}
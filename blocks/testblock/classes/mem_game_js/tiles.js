var IP = "192.168.178.20";
const TILEBACK = "http://localhost:8888/moodle310/blocks/testblock/classes/image_dir/tileback.jpg";
const TILEBACKALT = "tile back image";



const Animals= new Array();
var xhttp = new XMLHttpRequest();
var url ="http://localhost:8888/moodle310/blocks/testblock/classes/memgame.php";
xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    // Do what you want here with the response here
   
    var resultin =new Array();
    resultin = JSON.parse(this.responseText);
    var result = new Array(resultin.length - 1);
    var count = 0;
    for (let i = 0; i < result.length; i=i+3) {
        result[count] = {
            url: resultin[i],
            alt: resultin[i + 1],
            audio: resultin[i + 2]
        };  
        Animals.push(result[count]);
        ++count; 
        
    }
    
    console.log(result);
	
	// console.log(resultin);
    }
};

console.log("booyah",Animals);
xhttp.open("POST",url, true);
xhttp.send();


const others= new Array();
var xhttp1 = new XMLHttpRequest();
var url1 ="http://localhost:8888/moodle310/blocks/testblock/classes/others.php";
xhttp1.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    // Do what you want here with the response here
   
    var resultin1 =new Array();
    resultin1 = JSON.parse(this.responseText);
    var result1 = new Array(resultin1.length - 1);
    var count1 = 0;
    for (let i = 0; i < result1.length; i=i+3) {
        result1[count1] = {
            url: resultin1[i],
            alt: resultin1[i + 1],
            audio: resultin1[i + 2],
            //gif: resultin1[i + 3]
        };  
        others.push(result1[count1]);
        ++count1; 
        
    }
    
    console.log("fgg",result1);
	
	// console.log(resultin);
    }
};

console.log("booyah",others);
xhttp1.open("POST",url1, true);
xhttp1.send();

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>欢迎使用共享单车</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/normalize.css">
    <style>
        .container-small{
            max-width: 500px;
        }
        .container-big{
            max-width: 1200px;

        }
        #p1{
            background: green;
        }

        h1{
            text-align: center;
            margin: 30px 0;
        }
        #schbtn{
        	margin-left: 110px;
        }
    </style>
</head>
<body>
<p id="p1">power by Runking</p>

<form class="container container-big">
	<div class="form-inline">
	    <label>请输入当前位置：</label>
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon">X坐标</div>
                <input id="xpos" type="text" name="xpos" class="form-control" placeholder="xpos">
            </div>
        </div>
        <div class="form-group"> 
            <div class="input-group">
                <div class="input-group-addon">Y坐标</div>
                <input id="ypos" type="text" name="ypos" class="form-control" placeholder="ypos">
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon">搜索范围</div>
                <input id="range" type="text" name="range" class="form-control" placeholder="range">
            </div>
        </div>
    </div>
 	<p>附近自行车信息: <span id="canvas"></span></p>
    <canvas id="myCanvas" width="400" height="300">your browser does not support the canvas tag </canvas>
</form>
<button id='schbtn' class="btn btn-primary" onclick="ajax()">搜索附近</button>


<form class="container container-small" action="trans.php" method="POST">
    <div class="well">
        <div class="form-group">
            <label>请输入即将使用的自行车号：</label>
            <div class="input-group">
                <div class="input-group-addon">自行车号</div>
                <input type="text" name="bikeid" onkeyup="showHint(this.value)" class="form-control" placeholder="bike id">
            </div>
        </div>
    </div>
    <p>自行车信息: <span id="txtHint"></span></p>
    <button id="btn" name="submit" class="btn btn-primary btn-block" type="submit" value="submit">开始使用</button>
</form>

<script type="text/javascript">
//get the ava info
function showHint(str)
{

	if (str.length==0)
	{ 
		document.getElementById("txtHint").innerHTML="";
		return;
	}
	if (window.XMLHttpRequest)
	{
		// IE7+, Firefox, Chrome, Opera, Safari 浏览器执行的代码
		xmlhttp=new XMLHttpRequest();
	}
	else
	{	
		//IE6, IE5 浏览器执行的代码
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)//if ready receive
		{
			document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
			if(document.getElementById("txtHint").innerHTML === '1'){
				document,getElementById("submit").style.display="block";
				//alert('sss');
			}
			// if(xml.responseText === '1'){
			// 	document,getElementById("submit").disabled = false;
			// }else{
			// 	document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
			// }
		}
	}
	xmlhttp.open("GET","getflag.php?bikeid="+str,true);
	xmlhttp.send();
}

function ajax(){
	//get the array info
	var range = document.getElementById('range').value;
	var xpos = document.getElementById('xpos').value;
	var ypos = document.getElementById('ypos').value;

	if (window.XMLHttpRequest)
	{
		// IE7+, Firefox, Chrome, Opera, Safari 浏览器执行的代码
		xmlhttp=new XMLHttpRequest();
	}
	else
	{	
		//IE6, IE5 浏览器执行的代码
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		document.getElementById("canvas").innerHTML='';
		if (xmlhttp.readyState==4 && xmlhttp.status==200)//if ready receive
		{
			var value = document.getElementById("range").value;
			var myxpos = document.getElementById("xpos").value;
			var myypos = document.getElementById("ypos").value;

			// document.getElementById("canvas").innerHTML=xmlhttp.responseText;
			var arr = JSON.parse(xmlhttp.responseText);
			//document.getElementById("canvas").innerHTML=arr.length;//arr[0]['xpos'];
			var canvas=document.getElementById('myCanvas');
			var ctx=canvas.getContext('2d');
			ctx.clearRect(0, 0, canvas.width, canvas.height);
			ctx.fillStyle='#0000ff';
			ctx.fillRect(myxpos,myypos,5,5);

			ctx.fillStyle='#ff0000';

			ctx.beginPath();
			ctx.arc(myxpos,myypos,value,0,2*Math.PI);
			ctx.stroke();

			for (var i = arr.length - 1; i >= 0; i--) {
				document.getElementById("canvas").innerHTML+=" (bikeid: "+arr[i][0]+" ,xpos: "+arr[i][1]+" ,ypos: "+arr[i][2]+")";
				ctx.fillRect(arr[i][1],arr[i][2],5,5);//update the point of bike
			};

		}
	}
	xmlhttp.open("GET","findbike.php?range="+range+"&xpos="+xpos+"&ypos="+ypos,true);
	xmlhttp.send();
}
</script>
</body>
</html>

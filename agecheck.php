<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script
src=https://api.agechecked.com/api/jsapi/getjavascript?merchantkey=o6btFWd3qqHWf%2fY%2bPx5UozGwAl0oTcW%2bBwGmhw%2bj%2fNPGdPpkEC0BIGY2T9mYrQFP&version=1.0
type="text/javascript">
</script>
<script type="text/javascript">
function handlereturn(d) {
Agechecked.API.modalclose();
var msg = JSON.parse(d.data);
if(msg.status == 6 || msg.status == 7) {
var agecheckid=msg.agecheckid;
var ageverifiedid=msg.ageverifiedid;
console.log("agecheckid", agecheckid);
console.log("ageverifiedid", ageverifiedid);
// You can react to the successful age verification here
} else {
// alert("failed to authenticate");
// You can react to the failed age verification here
}
}
function openpop(a) {
Agechecked.API.registerreturn(handlereturn);
Agechecked.API.createagecheckjson(
{
mode: "javascript",
avtype: "agechecked"
}).done(function(json) {
Agechecked.API.modalopen(json.agecheckurl);
});
}
</script>
</head>
<body>
<div>
<button onclick="openpop(0); return false;" type="button">Age Verification</button>
</div>
</body>

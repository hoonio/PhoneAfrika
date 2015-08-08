<h3>Get Subscriber Call History</h3>
<form action="#" method="post"><label>Phone number <input id="phoneNumber" type="text" name="phoneNumber" placeholder="447430702004" onchange="numberEntered(this);" /> </label> <label>Date From: <input id="datefrom" type="text" name="voucher" placeholder="2014-02-21" onchange="datefEntered(this);" /> </label> <label>Date To: <input id="voucher" type="text" name="dateto" placeholder="2014-03-19" onchange="dateEntered(this);" /> </label></form><form action="http://phoneafrika.s.im/pip/api/execute.mth" method="post" target="history-results"><textarea id="history-parameter" style="display: none;" name="xml">call-history-parameter</textarea><input class="btn" id="submit" type="submit" value="Call History" /></form>Show Call History <iframe id="history-results" name="history-results" height="150" width="100%"></iframe>
	
<script type="text/javascript">
window.onload=function(){
    var ifr=document.getElementById('results');
    ifr.onload=function(){
        this.style.display='block';
        console.log('load the iframe')
    };
};
function dateEntered( date )
{
	var phoneNumber = document.getElementById( "phoneNumber" );
	console.log(phoneNumber.value);
	var datefrom = document.getElementById( "datefrom" );
	console.log(datefrom.value);
	var dateto = document.getElementById( "dateto" );
	console.log(dateto.value);
	var historyParameter = document.getElementById( "history-parameter" );
	historyParameter.value = "<get-customer-call-history version='1'><authentication><username>david.sutton@coms.com</username><password>Menorca73#</password></authentication><number>" + phoneNumber.value + "</number><start>" + datefrom.value + "</start><end>" + dateto.value + "</end></get-customer-call-history>";
	console.log(historyParameter.value);
}
</script>

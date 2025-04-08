
function buynow(id,amount,message,name) {
    var x = new XMLHttpRequest();
    x.onreadystatechange = function() {
        if (x.readyState == 4 ) {
            console.log(x.responseText);
            var text = x.responseText;



            if (text == "2") { //benificiary ID not found
                alert("Invalid benificiary Id");
            } else if(text=="3"){
                alert("please login");
                window.location="index.php";
            }
            else {      //payment gateway here
                

                var obj=JSON.parse(text);

                var mail=obj["email"];  //usermail
                var id=obj["id"];       //beniId
                var amount=obj["amount"]; 
                var item=obj["item"];         //benificiaryName
                var hash=obj["hash"];    
             

    payhere.onCompleted = function onCompleted(orderId) {
       // alert("Payment completed");
       
        
            // Redirect to the invoice page with parameters: id, amount, message, and name
             window.location = "invoice.php?id=" + id + "&amount=" + amount + "&message=" + encodeURIComponent(message) + "&name=" + encodeURIComponent(name);
           // window.location="invoice.php";
        
        

    };

    // Payment window closed
    payhere.onDismissed = function onDismissed() {
        // Note: Prompt user to pay again or show an error page
        alert("Payment dismissed");
    };

    // Error occurred
    payhere.onError = function onError(error) {
        // Note: show an error page
        alert("Invalid Details.");
    };

    // Put the payment variables here
    var payment = {
        "sandbox": true,
        "merchant_id": "1228342",    // Replace your Merchant ID
        "return_url": "http://localhost/Project1/Stories.php",     // Important
        "cancel_url": "http://localhost/Project1/Stories.php",     // Important
        "notify_url": "http://sample.com/notify",
        "order_id": id,
        "items": item,
        "amount": amount,
        "currency": "LKR",
        "hash": hash, // *Replace with generated hash retrieved from backend
        "first_name": item,
        "last_name": "",
        "email": mail,
        "phone": "",
        "address": "No.1, Galle Road",
        "city": "Colombo",
        "country": "Sri Lanka",
        "delivery_address": "No. 46, Galle road, Kalutara South",
        "delivery_city": "Kalutara",
        "delivery_country": "Sri Lanka",
        "custom_1": "",
        "custom_2": ""
    };

    // Show the payhere.js popup, when "PayHere Pay" is clicked
    
        payhere.startPayment(payment);
   
            }
        }
    };
        // payhere end

        // x.open("GET", "../DonateNow.php?id=" + id + "&amount=" + amount, true);
        x.open("GET", "DonateNow.php?id=" + id + "&amount=" + amount, true);
        // Make sure the path to DonateNow.php is correct
    x.send();
}



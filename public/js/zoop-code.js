function openGateway() {
      // To setup gateway UI to mach your application you can
      // pass the gateway options but the support for it will be
      // added soon
      zoop.eSignGatewayInit({
      // mode: "<<TAB | REDIRECT>>", // default TAB, but choose either of them
        mode: "REDIRECT",
          zoomLevel: 1, // Default: 7, integer between 1 to 7. PDF viewer zoom level.
      });
      // Pass the transaction ID created at Init call
      var kycrequest_id=$("#kycrequest_id").val();
        zoop.eSignGateway(kycrequest_id);
}


openGateway();


          zoop.on("consent-denied", (message) => {
                // handle the event
          });
          zoop.on("gateway-error", (message) => {
                // handle the event
          });
          zoop.on("esign-success", (message) => {
                  // handle the success event
          });
          zoop.on("esign-error", (message) => {
                  // handle the failure event
          });

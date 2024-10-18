//Copy text to clipboard by clciking copy icon
function copyToClipboard(selector){
    copyText = $("#" + selector).html()
    navigator.clipboard.writeText(copyText);
    $(".copy-to-clipboard-icon").attr("data-original-title", "Copy to clipboard").parent().find('.tooltip-inner').html("Copy to clipboard");
    $(".ctc_"+selector+" .copy-to-clipboard-icon").attr("data-original-title", "Copied to clipboard").parent().find('.tooltip-inner').html("Copied to clipboard");

    $(document).on("mouseleave", ".ctc_" + selector + " .copy-to-clipboard-icon", function(){
        sleep(500).then(() => {
            $(".copy-to-clipboard-icon").attr("data-original-title", "Copy to clipboard").parent().find('.tooltip-inner').html("Copy to clipboard");
        });
    });

    //$("strong.copy-to-clipboard-text").css({'background-color' : "", "padding" : "", "line-height" : ""});
    //$(".copy_to_clipboard .fa-clipboard").css({'margin-top' : ""});
    //$(".ctc_"+selector+" .fa-clipboard").css({'margin-top' : ""});
    //$("#" + selector).css({'background-color' : "#ccc", "padding" : "4px", "line-height" : "20px"});
    //$(".ctc_"+selector+" .fa-clipboard").css({'margin-top' : "6px"});
}
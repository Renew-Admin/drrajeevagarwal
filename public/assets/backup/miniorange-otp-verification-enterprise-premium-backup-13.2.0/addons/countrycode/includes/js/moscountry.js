 jQuery(document).ready(function () {

            $mo = jQuery;
            var countryOptionSelected = "";
            var disableSelectoption=true;
            var blockCountryOptionSelected = "";
            var blockcountrydisableSelectoption=true;
                       
        $mo( "#country_dropdown" ).change(function () {
                $mo(this).find("option:selected" ).each(function() {
                countryOptionSelected =   $mo( this ).text() + " ";
                });

        if(disableSelectoption){ 
        disableSelectoption=false;
        return;}
                                                     
        if(countryOptionSelected!="----Select Your Country----"){
             var totalCountriesSelected =    $mo("#mo_selected_country_numbers").val();  
             totalCountriesSelected +=countryOptionSelected;
             totalCountriesSelected=totalCountriesSelected+";";
             $mo("#mo_selected_country_numbers").val(totalCountriesSelected);
             }
                           
        })
        .change();     

        $mo( "#country_block_dropdown" ).change(function () {
                $mo(this).find("option:selected" ).each(function() {
                blockCountryOptionSelected =   $mo( this ).text() + " ";
                });

        if(blockcountrydisableSelectoption){ 
        blockcountrydisableSelectoption=false;
        return;}
                                                 
        if(blockCountryOptionSelected!="----Select Your Country----"){
             var totalBlockCountriesSelected =    $mo("#mo_block_selected_country_numbers").val();  
             totalBlockCountriesSelected +=blockCountryOptionSelected;
             totalBlockCountriesSelected=totalBlockCountriesSelected+";";
             $mo("#mo_block_selected_country_numbers").val(totalBlockCountriesSelected);
             }
                           
        })
        .change();           

 });
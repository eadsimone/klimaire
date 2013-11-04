function Reason_of_Failure_data(input)
{
	switch(input)
	{
		case 'Refrigerant System':		
			document.getElementById('res_failure_compocode').style.display = 'none';		
			document.getElementById('res_failure_compocode1').style.display = 'block';
			document.getElementById('res_failure_compocode2').style.display = 'none';
			document.getElementById('res_failure_compocode3').style.display = 'none';
			document.getElementById('res_failure_compocode4').style.display = 'none';
			document.getElementById('res_failure_compocode5').style.display = 'none';				
		break;
		
		case 'Compressor / Motors':		
			document.getElementById('res_failure_compocode').style.display = 'none';		
			document.getElementById('res_failure_compocode1').style.display = 'none';
			document.getElementById('res_failure_compocode2').style.display = 'block';
			document.getElementById('res_failure_compocode3').style.display = 'none';	
			document.getElementById('res_failure_compocode4').style.display = 'none';
			document.getElementById('res_failure_compocode5').style.display = 'none';						
		break;
		
		case 'Electrical Components':		
			document.getElementById('res_failure_compocode').style.display = 'none';		
			document.getElementById('res_failure_compocode1').style.display = 'none';
			document.getElementById('res_failure_compocode2').style.display = 'none';
			document.getElementById('res_failure_compocode3').style.display = 'block';	
			document.getElementById('res_failure_compocode4').style.display = 'none';
			document.getElementById('res_failure_compocode5').style.display = 'none';						
		break;
		
		case 'Non-Electrical Components':		
			document.getElementById('res_failure_compocode').style.display = 'none';		
			document.getElementById('res_failure_compocode1').style.display = 'none';
			document.getElementById('res_failure_compocode2').style.display = 'none';
			document.getElementById('res_failure_compocode3').style.display = 'none';	
			document.getElementById('res_failure_compocode4').style.display = 'block';
			document.getElementById('res_failure_compocode5').style.display = 'none';						
		break;
		
		case 'Gas Furnace / Boiler':		
			document.getElementById('res_failure_compocode').style.display = 'none';		
			document.getElementById('res_failure_compocode1').style.display = 'none';
			document.getElementById('res_failure_compocode2').style.display = 'none';
			document.getElementById('res_failure_compocode3').style.display = 'none';	
			document.getElementById('res_failure_compocode4').style.display = 'none';
			document.getElementById('res_failure_compocode5').style.display = 'block';						
		break;
		
		default:
			document.getElementById('res_failure_compocode').style.display = 'block';		
			document.getElementById('res_failure_compocode1').style.display = 'none';
			document.getElementById('res_failure_compocode2').style.display = 'none';
			document.getElementById('res_failure_compocode3').style.display = 'none';	
			document.getElementById('res_failure_compocode4').style.display = 'none';
			document.getElementById('res_failure_compocode5').style.display = 'none';		
		
					
	}
	

	switch(input)
	{
		case 'Refrigerant System':
			document.getElementById('res_failure_causecode').style.display = 'none';
			document.getElementById('res_failure_causecode1').style.display = 'block';
			document.getElementById('res_failure_causecode2').style.display = 'none';
			document.getElementById('res_failure_causecode3').style.display = 'none';
			document.getElementById('res_failure_causecode4').style.display = 'none';
			document.getElementById('res_failure_causecode5').style.display = 'none';				
		break;
		
		case 'Compressor / Motors':		
			document.getElementById('res_failure_causecode').style.display = 'none';		
			document.getElementById('res_failure_causecode1').style.display = 'none';
			document.getElementById('res_failure_causecode2').style.display = 'block';
			document.getElementById('res_failure_causecode3').style.display = 'none';	
			document.getElementById('res_failure_causecode4').style.display = 'none';
			document.getElementById('res_failure_causecode5').style.display = 'none';						
		break;
		
		case 'Electrical Components':		
			document.getElementById('res_failure_causecode').style.display = 'none';		
			document.getElementById('res_failure_causecode1').style.display = 'none';
			document.getElementById('res_failure_causecode2').style.display = 'none';
			document.getElementById('res_failure_causecode3').style.display = 'block';	
			document.getElementById('res_failure_causecode4').style.display = 'none';
			document.getElementById('res_failure_causecode5').style.display = 'none';						
		break;
		
		case 'Non-Electrical Components':		
			document.getElementById('res_failure_causecode').style.display = 'none';		
			document.getElementById('res_failure_causecode1').style.display = 'none';
			document.getElementById('res_failure_causecode2').style.display = 'none';
			document.getElementById('res_failure_causecode3').style.display = 'none';	
			document.getElementById('res_failure_causecode4').style.display = 'block';
			document.getElementById('res_failure_causecode5').style.display = 'none';						
		break;
		
		case 'Gas Furnace / Boiler':		
			document.getElementById('res_failure_causecode').style.display = 'none';		
			document.getElementById('res_failure_causecode1').style.display = 'none';
			document.getElementById('res_failure_causecode2').style.display = 'none';
			document.getElementById('res_failure_causecode3').style.display = 'none';	
			document.getElementById('res_failure_causecode4').style.display = 'none';
			document.getElementById('res_failure_causecode5').style.display = 'block';						
		break;
		
		default:
			document.getElementById('res_failure_causecode').style.display = 'block';		
			document.getElementById('res_failure_causecode1').style.display = 'none';
			document.getElementById('res_failure_causecode2').style.display = 'none';
			document.getElementById('res_failure_causecode3').style.display = 'none';	
			document.getElementById('res_failure_causecode4').style.display = 'none';
			document.getElementById('res_failure_causecode5').style.display = 'none';								
		
					
	}

	
}
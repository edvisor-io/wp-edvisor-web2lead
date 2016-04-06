=== Plugin Name ===
Contributors: (this should be a list of wordpress.org userid's)
Tags: edvisor, edvisor.io
Requires at least: 1.0.0
Tested up to: 1.1.0
Stable tag: 1.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==
Edvisor web2lead forms for Wordpress


== Installation ==
1. Download as zip format
2. Upload zip file via Wordpress Plugins

How to use
1. First add an Agency ID and an API Key then hit 'Save All Changes'
2. Check any options you want included in your form, and save again.
3. Include the short code [edvisor_form] into your post/page/widget.

Additional Options
How to make a field required
1. Check the checkbox under the required column.

How to add your own dropdown
1. Some fields have the option to add your own dropdown. If the field has the option, check the checkbox.
2. After you check the checkbox, an option to '+ Add More' will appear. Click to add more options into your dropdown. 
3. Fill the field with what you want the option to say.
4. Destinations and City, Provices/Regions options must be selected from the list of places shown when you type into the field. 
5. You can delete an option by clicking on the x.

How to add a custom field
1. Under custom fields, click on the '+ Add Custom Field'.
2. Match up the options you have in your custom field in Edvisor to the options here.
3. The Label Name can be whatever you want shown, but the custom field type (dropdown/text/date), the ID, and if using a dropdown, the dropdown options must be the same as the fields in Edvisor.

Settings
- Submit text is the text on the button
- Required Validation Message will only show on fields that are required. 
- Email Validation Message will only show if the email is wrong.
- Success Action is what happens when a form has successfully been submitted. It has two options. A message or a URL.
  - A Message will display at the bottom of the form.
  - A URL will redirect to the url provided.

CSS
- You can change the look of your form by adding css here.
- For example 
``` #edvisor-form { padding: 20px; width: 400px; }
``` will add a padding of 20px around your form and make it a width of 400px.

Javascript
- Don't touch if you're not sure what you're doing. Contact Edvisor if you need help.
- There are two text areas for Javascript.
- 'General' will be applied before the code will run. Here you can inject code into the form.
- 'Before Post' will be applied right before it makes the AJAX POST. Here you can change the data before it gets posted to the Edvisor API. You can change the data by access the variable 'data' object. 


Notes
- Edvisor API Docs http://docs.edvisor.io/
Routes
=======

Example file containing available routes directives, you can see how it may be used

Parent is a folder containing paths that begining from the parent path, so paths

```
auth/login
auth/register
auth/reset
```

will organized to

```
auth
    login
    register
    reset
```

Its just a helper.

The Api Factory uses uriPrefix parameter described in api-factory.php file  
So, if your route contains auth/login path, it will converted to uriPrefix/auth/login , for example /api/v1/auth/login


Path structure:
---------------

path: **subpath**  
description: path description, you may describe what this endpoint doing  
tags: **tags_array**   
method: **request_method**   
middlewares: **middlewares_array**   
headers:  
  header_key: **rules**  
tags: **tags_array**   
params:  
  param_key: **rules**   
produces: **produces_array**   
responses:  
..  **response_code**:  
..  ..  description: response_description
..  ..  schema:  
..  ..  ..  items:  
..  ..  ..  ..  "$ref": "#/definitions/response_definition"  

### headers and params section

Headers is a list of request headers, optional parameter, used by Swagger documentor  
Params is a list of request parameters, optional parameter  
Params section used by Swagger documentor, also, Params rules are used in Action validator 

### subpath
Subpath is a part of path

### tags_array
Optional parameter, used to generate Swagger documentation

### request_method
post,get,patch,delete etc

### middlewares_array
Optional parameter, will used in Laravel routes as middlewares

### rules
Laravel validator rules, for example, string|required  
When new action created, params rules will added to a validation rules array   
Also may be used in Swagger documentation

### produces_array
Optional parameter, used to generate Swagger documentation as produces parameter
For example [application_json]  



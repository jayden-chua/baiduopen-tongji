## About library.baidu-tongji
 library.baidu-tongji is a helper library that helps to connect and download relevant reports from Baidu Tongji.  

## Before Using
To use this library, please make sure you have already an account with Baidu Tongji and have already authorized the API token.

For more information on how to setup Baidu Tongji Account, please visit https://tongji.baidu.com/web/welcome/login

## Usage
To use this library, 
1. New up a Service Manager
2. Login with username, password, token and UUID. 
    - username is the account username for Baidu Tongji
    - password is the account password for Baidu Tongji
    - token is the token provided after you authorized for using API
    - UUID is some string that you can provide to state your identity (e.g MAC Address)
3. Use the most generic getData with $parameters or more specific methods, see API Methods below
    - $parameters is an array that looks has the following
        - 'site_id': this should be return from baidu api getSiteList
        - 'method': method name, see documentation (e.g 'overview/getTimeTrendRpt')
        - 'start_date': string start time (e.g '20170831000000') 
        - 'end_date': string end time (e.g '20170831000000') 
        - 'max_results': integer, maxiumum result per call 
        - 'gran': granularity, 'day/hour/week/month'
        - 'metrics': fields that are required for method call, see documentation
        - 'order': string, using comma to seperate field and direction of sort (e.g, 'pv_count,asc')  
4. Logout
````
$serviceManager = new ServiceManager($username, $password, $token, $uuid);

$serviceManager->login();
$serviceManager->reportService->getData($parameters);
$serviceManager->logout();
````


## API Methods

### getOverviewTimeTrendByDay

This method calls Baidu Tuiguang method 'overview/getTimeTrendRpt'. 

#### Parameters

- siteId : Site Id provided by Baidu
- startTime : Start Time in format 'YYYYMMDDHHMM' 
- endTime : End Time in format 'YYYYMMDDHHMM'

#### Returns
 
- BaiduParams Object
     

### getOverviewDistrictByDay

This method calls Baidu Tuiguang method 'overview/getDistrictRpt'. 

#### Parameters

- siteId : Site Id provided by Baidu
- startTime : Start Time in format 'YYYYMMDDHHMM' 
- endTime : End Time in format 'YYYYMMDDHHMM'

#### Returns
 
- BaiduParams Object

### getOverviewCommonTrackByDay

This method calls Baidu Tuiguang method 'overview/getCommonTrackRpt'.

#### Parameters

- siteId : Site Id provided by Baidu
- startTime : Start Time in format 'YYYYMMDDHHMM' 
- endTime : End Time in format 'YYYYMMDDHHMM'

#### Returns
 
- BaiduParams Object

### getProProductByDay

This method calls Baidu Tuiguang method 'pro/product/a'.

#### Parameters

- siteId : Site Id provided by Baidu
- startTime : Start Time in format 'YYYYMMDDHHMM' 
- endTime : End Time in format 'YYYYMMDDHHMM'

#### Returns
 
- BaiduParams Object

### getTrendTimeByDay

This method calls Baidu Tuiguang method 'trend/time/a'.

#### Parameters

- siteId : Site Id provided by Baidu
- startTime : Start Time in format 'YYYYMMDDHHMM' 
- endTime : End Time in format 'YYYYMMDDHHMM'

#### Returns
 
- BaiduParams Object

### getProHourByDay

This method calls Baidu Tuiguang method 'pro/hour/a'.

#### Parameters

- siteId : Site Id provided by Baidu
- startTime : Start Time in format 'YYYYMMDDHHMM' 
- endTime : End Time in format 'YYYYMMDDHHMM'

#### Returns
 
- BaiduParams Object

### getSourceAllByDay

This method calls Baidu Tuiguang method 'source/all/a'.

#### Parameters

- siteId : Site Id provided by Baidu
- startTime : Start Time in format 'YYYYMMDDHHMM' 
- endTime : End Time in format 'YYYYMMDDHHMM'

#### Returns
 
- BaiduParams Object

### getSourceEngineByDay

This method calls Baidu Tuiguang method 'source/engine/a'.

#### Parameters

- siteId : Site Id provided by Baidu
- startTime : Start Time in format 'YYYYMMDDHHMM' 
- endTime : End Time in format 'YYYYMMDDHHMM'

#### Returns
 
- BaiduParams Object

### getSourceSearchwordByDay

This method calls Baidu Tuiguang method 'source/searchword/a'.

#### Parameters

- siteId : Site Id provided by Baidu
- startTime : Start Time in format 'YYYYMMDDHHMM' 
- endTime : End Time in format 'YYYYMMDDHHMM'

#### Returns
 
- BaiduParams Object

### getSourceLinkByDay

This method calls Baidu Tuiguang method 'source/link/a'.

#### Parameters

- siteId : Site Id provided by Baidu
- startTime : Start Time in format 'YYYYMMDDHHMM' 
- endTime : End Time in format 'YYYYMMDDHHMM'

#### Returns
 
- BaiduParams Object

### getVisitToppageByDay

This method calls Baidu Tuiguang method 'visit/toppage/a'.

#### Parameters

- siteId : Site Id provided by Baidu
- startTime : Start Time in format 'YYYYMMDDHHMM' 
- endTime : End Time in format 'YYYYMMDDHHMM'

#### Returns
 
- BaiduParams Object

### getVisitLandingPageByDay

This method calls Baidu Tuiguang method 'visit/landingpage/a'.

#### Parameters

- siteId : Site Id provided by Baidu
- startTime : Start Time in format 'YYYYMMDDHHMM' 
- endTime : End Time in format 'YYYYMMDDHHMM'

#### Returns
 
- BaiduParams Object

### getVisitTopDomainByDay

This method calls Baidu Tuiguang method 'visit/topdomain/a'.

#### Parameters

- siteId : Site Id provided by Baidu
- startTime : Start Time in format 'YYYYMMDDHHMM' 
- endTime : End Time in format 'YYYYMMDDHHMM'

#### Returns
 
- BaiduParams Object

### getVisitDistrictByDay

This method calls Baidu Tuiguang method 'visit/district/a'.

#### Parameters

- siteId : Site Id provided by Baidu
- startTime : Start Time in format 'YYYYMMDDHHMM' 
- endTime : End Time in format 'YYYYMMDDHHMM'

#### Returns
 
- BaiduParams Object

### getVisitWorldByDay

This method calls Baidu Tuiguang method 'visit/world/a'.

#### Parameters

- siteId : Site Id provided by Baidu
- startTime : Start Time in format 'YYYYMMDDHHMM' 
- endTime : End Time in format 'YYYYMMDDHHMM'

#### Returns
 
- BaiduParams Object


 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
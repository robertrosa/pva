<?php

include 'conn_database.php';

/*fill serviceID & latest period*/
$GLOBALS['service'] = "Worldpanel";//$_POST['service'];
$GLOBALS['serviceID'] = "";
$GLOBALS['LatestPeriod'] = "";
function fillVars(){
    $query = mssql_query("SELECT serviceID, service, ServiceName, LatestPeriod From Service WHERE (LatestPeriod IS NOT NULL) AND service like '". $GLOBALS['service'] ."' ORDER BY pvaDisplaySequence");
    
    $row = mssql_fetch_array($query);
    $GLOBALS['serviceID'] = $row["serviceID"];    
    $GLOBALS['LatestPeriod'] = $row["LatestPeriod"];    
}

/*fill intervals*/
$GLOBALS['intervals'] = array(0, 8, 16, 24, 32, 40, 48);
function fillIntervals(){
        
    $query = mssql_query('select MIN(PrepDate) 
              FROM   pva_production INNER JOIN 
              orders ON pva_production.OrderId = orders.orderID 
              WHERE  (pva_production.ProductionTypeId=1) AND (orders.serviceID = "' . $GLOBALS['serviceID'] .'") AND (pva_production.Period = "' . $GLOBALS['LatestPeriod'] . '")');    
    $row = mssql_fetch_array($query);
    $now = date("Y-m-d H:i:s");
    $hourdiff = round((strtotime($now) - strtotime($row[0]))/3600, 2);
    $diffIntervals = round($hourdiff/6, 0);
    $GLOBALS['intervals'] = array(0, $diffIntervals*1, $diffIntervals*2, $diffIntervals*3, $diffIntervals*4, $diffIntervals*5, ($diffIntervals*6)-1);    
    
}

/*Admin server status*/
function getAdminServerStatus(){
    $query = mssql_query('SELECT pva_server.ServerId, pva_server.pvaStatusId, pva_server.ServerName, pva_mode.pvaMode, pva_serverstatus.pvaStatus,
                        DATEADD(hour, DATEDIFF(hour, getutcdate(), GETDATE()), pva_server.LastTimeCheck) AS LastTimeCheck, 
                        DATEADD(hour, DATEDIFF(hour, getutcdate(), GETDATE()), pva_server.NextPvDemon) AS NextPvDemon, 
                        DATEADD(hour, DATEDIFF(hour, getutcdate(), GETDATE()), pva_server.NextPvJobSub) AS NextPvJobSub, 
                        DATEADD(hour, DATEDIFF(hour, getutcdate(), GETDATE()), pva_server.NextPvDownload) AS NextPvDownload
                        FROM pva_server INNER JOIN
                        pva_mode ON pva_server.pvaModeId = pva_mode.pvaModeId INNER JOIN
                        pva_serverstatus ON pva_server.pvaStatusId = pva_serverstatus.pvaStatusId
                        WHERE (pva_server.pvaModeId = 1) 
                        ORDER BY pva_server.DisplaySequence, pva_server.ServerName');
    
    while($row = mssql_fetch_assoc($query))
    {
        $result = $row;
    }
    return json_encode($result);   
}

/*Number of active servers*/
function getNrServersActive(){
    $query = mssql_query('select Count (*) from [PowerView].[powerview].[pva_server]
  					      where pvaModeId=2 and pvaStatusID = 2');    
    
    $row = mssql_fetch_array($query);
    if ($row[0] > 0) {
      return $row[0];
    } else {
      return 0;
    }    
}

/*Number of standby servers*/
function getNrServersOnStandby(){
    $query = mssql_query('select Count (*) from [PowerView].[powerview].[pva_server]
  					      where pvaModeId=2 and pvaStatusID = 3');    
    
    $row = mssql_fetch_array($query);
    if ($row[0] > 0) {
      return $row[0];
    } else {
      return 0;
    }
}

/*Number of inactive servers*/
function getNrServersInactive(){
    $query = mssql_query('select Count (*) from [PowerView].[powerview].[pva_server]
  					      where pvaModeId=0 and pvaStatusID = 0 and ProductionStatus = 1');    
    
    $row = mssql_fetch_array($query);
    if ($row[0] > 0) {
      return $row[0];
    } else {
      return 0;
    }
}

/*get Admin Server Info*/
function getAdminServerInfo(){
    $query = mssql_query('SELECT pva_server.ServerName, pva_mode.pvaMode, pva_serverstatus.pvaStatus, pva_server.LastTimeCheck, pva_production.OrderNumber,
                    pva_production.DataPeriod, pva_production.NumPeriods, pva_production.BuildMode, pva_server.ServerId, pva_server.pvaStatusId,
                    pva_production.StatusDescription, pva_order_prodn.AverageBuildTime,
                    DATEADD(hour, DATEDIFF(hour, getutcdate(), GETDATE()), pva_production.BuildTimeStart) AS BuildTimeStart
                    FROM      pva_server INNER JOIN
                    pva_mode ON pva_server.pvaModeId = pva_mode.pvaModeId INNER JOIN
                    pva_serverstatus ON pva_server.pvaStatusId = pva_serverstatus.pvaStatusId LEFT OUTER JOIN
                    pva_production ON pva_server.PvaProdId = pva_production.PvaProdId LEFT OUTER JOIN
                    pva_order_prodn ON pva_production.OrderId = pva_order_prodn.OrderId
                    WHERE     (pva_server.pvaModeId = 2) OR ((pva_server.ProductionStatus=1) AND (pva_server.pvaModeId <> 1))
                    ORDER BY  pva_server.DisplaySequence, pva_server.ServerName');
    
    while($row = mssql_fetch_assoc($query))
    {
        $result = $row;
    }
    return json_encode($result); 
}

/*get Admin Server Info*/
function getServersInfo(){
    $query = mssql_query('SELECT     pva_server.ServerName, pva_mode.pvaMode, pva_serverstatus.pvaStatus, pva_server.LastTimeCheck, pva_production.OrderNumber, 
                               pva_production.DataPeriod, pva_production.NumPeriods, pva_production.BuildMode, pva_server.ServerId, pva_server.pvaStatusId, 
                               pva_production.StatusDescription, pva_order_prodn.AverageBuildTime, 
                               DATEADD(hour, DATEDIFF(hour, getutcdate(), GETDATE()), pva_production.BuildTimeStart) AS BuildTimeStart 
                     FROM      pva_server INNER JOIN 
                               pva_mode ON pva_server.pvaModeId = pva_mode.pvaModeId INNER JOIN 
                               pva_serverstatus ON pva_server.pvaStatusId = pva_serverstatus.pvaStatusId LEFT OUTER JOIN 
                               pva_production ON pva_server.PvaProdId = pva_production.PvaProdId LEFT OUTER JOIN 
                               pva_order_prodn ON pva_production.OrderId = pva_order_prodn.OrderId 
                     WHERE     (pva_server.pvaModeId = 2) OR ((pva_server.ProductionStatus=1) AND (pva_server.pvaModeId <> 1))
                     ORDER BY  pva_server.DisplaySequence, pva_server.ServerName');
     
    while($row = mssql_fetch_assoc($query))
    {
        $result[] = $row;
    }
    return json_encode($result); 
}

/*get Active Servers per hour last 24 hours*/
function getServersPerHour(){
    $query = mssql_query('select count(DISTINCT t.ServerName), t.Hour
                          from (select ServerName, dateadd(HH, datediff(HH,0, BuildTimeStart), 0) As Hour
                          from pva_production
                          where period = 201508 and BuildTimeStart > dateadd(HH, -24, getdate())
                          union all
                          select ServerName, dateadd(HH, datediff(HH, 0, dateadd(ss, BuildSeconds, BuildTimeStart)), 0) as Hour
                          from pva_production
                          where period = ' . $row1["LatestPeriod"] .' and BuildTimeStart > dateadd(HH, -24, getdate())) t
                          Group By t.Hour');
     
    while($row = mssql_fetch_assoc($query))
    {
        $result[] = $row;
    }
    return json_encode($result); 
}

/* Nr of events by level last 4 weeks*/
function getNrEvents($level){
    $query = mssql_query('SELECT COUNT(pvaEventId)
                    FROM       pva_eventlog 
                    WHERE     (ClearedBy IS NULL) AND (Severity=' . $level . ') 
                    GROUP BY   Severity');    
    
    $row = mssql_fetch_array($query);
    if ($row[0] > 0) {
      return $row[0];
    } else {
      return 0;
    }
    
}

/* Nr total of events last 4 weeks*/
function getNrTotalEvents(){
    $query = mssql_query('SELECT COUNT(pvaEventId)
                    FROM       pva_eventlog 
                    WHERE     (ClearedBy IS NULL)');
    
    $row = mssql_fetch_array($query);
    if ($row[0] > 0) {
      return $row[0];
    } else {
      return 0;
    }
}

/*get Databases Info V1*/
/*original version, not being used at the moment, could be at the future, keep*/
function getDatabasesInfoV1(){
    $query1 = mssql_query('SELECT serviceID, service, ServiceName, LatestPeriod From Service WHERE (LatestPeriod IS NOT NULL) ORDER BY pvaDisplaySequence');
    $result;
    while($row1 = mssql_fetch_array($query1))
    {                
        $query2 = mssql_query('select
                            firstQuery.TotalDatabases,
                            secondQuery.CompletedDatabases
                            from
                            (
                                SELECT orders.serviceID, count(pva_production.OrderId) AS TotalDatabases, pva_production.ProductionTypeId
                                      FROM   pva_production INNER JOIN 
                                             orders ON pva_production.OrderId = orders.orderID 
                                      WHERE (pva_production.ProductionTypeId=1) AND (orders.serviceID = ' . $row1["serviceID"] . ') AND (pva_production.Period = ' . $row1["LatestPeriod"] .')
                                      GROUP BY orders.serviceID, pva_production.ProductionTypeId
                            ) as firstQuery
                            inner join
                            (
                            SELECT orders.serviceID, COUNT(pva_production.OrderId) AS CompletedDatabases, pva_production.ProductionTypeId
                                      FROM   pva_production INNER JOIN 
                                             orders ON pva_production.OrderId = orders.orderID 
                                      WHERE (pva_production.ProductionTypeId=1) AND (orders.serviceID = ' . $row1["serviceID"] . ') AND (pva_production.Period = ' . $row1["LatestPeriod"] .')
                                             AND (DatabaseStatus="C")
                                      GROUP BY orders.serviceID, pva_production.ProductionTypeId
                            ) as secondQuery
                            on firstQuery.ProductionTypeId = secondQuery.ProductionTypeId');

        while($row2 = mssql_fetch_assoc($query2))
        {            
            $result[$row1["service"]] = $row2;
        }    
    }

    return json_encode($result); 

}

/*get Databases Info test version 3*/
function getDatabasesInfo($service){
    $result;        
    foreach ($GLOBALS['intervals'] as $interval){
        $date = date("Y-m-d H:i:s", strtotime('-'. $interval .' hour'));
        $query = mssql_query('select
                            firstQuery.TotalDatabases,
                            secondQuery.CompletedDatabases,
                            thirdQuery.DownloadedDatabases,
                            '.$interval.' AS hours
                            from
                            (
                                SELECT orders.serviceID, count(pva_production.OrderId) AS TotalDatabases
                                      FROM   pva_production INNER JOIN 
                                             orders ON pva_production.OrderId = orders.orderID 
                                      WHERE (pva_production.ProductionTypeId=1) AND (orders.serviceID = ' . $GLOBALS['serviceID'] . ') AND (pva_production.Period = ' . $GLOBALS['LatestPeriod'] .') AND (pva_production.DatabaseDate < "'. $date .'" or pva_production.DatabaseDate = NULL)
                                      GROUP BY orders.serviceID, pva_production.ProductionTypeId
                            ) as firstQuery
                            left join
                            (
                            SELECT orders.serviceID, COUNT(pva_production.OrderId) AS CompletedDatabases
                                      FROM   pva_production INNER JOIN 
                                             orders ON pva_production.OrderId = orders.orderID 
                                      WHERE (pva_production.ProductionTypeId=1) AND (orders.serviceID = ' . $GLOBALS['serviceID'] . ') AND (pva_production.Period = ' . $GLOBALS['LatestPeriod'] .') AND (pva_production.DatabaseDate < "'. $date .'")
                                             AND (DatabaseStatus="C")
                                      GROUP BY orders.serviceID, pva_production.ProductionTypeId
                            ) as secondQuery 
                            on firstQuery.serviceID = secondQuery.serviceID                               
                            left join
                            (
                            SELECT ServiceId, COUNT(*) AS DownloadedDatabases
                                      FROM   FtpDeliveryEmails
                                      WHERE ServiceId = ' . $GLOBALS['serviceID'] . ' and Period = ' . $GLOBALS['LatestPeriod'] .' and SentDate< "'. $date .'"
                                      Group By ServiceId                                  
                            ) as thirdQuery
                            on firstQuery.serviceID = thirdQuery.serviceID');

        while($row = mssql_fetch_assoc($query))
        {      
            //echo json_encode($row2) . "<br>";      
            $result[$GLOBALS['service']."-".array_search($interval, $GLOBALS['intervals'])] = $row;
        }    
    }


    return json_encode($result); 

}

/*get Deliverable Databases Info*/
function getDeliverablesInfo(){
    $result;
    $query = mssql_query('select
                        firstQuery.TotalDeliverables,
                        secondQuery.CompletedDeliverables
                        from
                        (
                            SELECT orders.serviceID, COUNT(DISTINCT pva_production.OrderId) AS TotalDeliverables
                                      FROM   pva_production INNER JOIN 
                                               orders ON pva_production.OrderId = orders.orderID INNER JOIN 
                                                 receives ON pva_production.OrderId = receives.orderID 
                                      WHERE  (orders.serviceID = ' . $GLOBALS['serviceID'] . ') AND (receives.statusID = 1) AND (pva_production.Period = ' . $GLOBALS['LatestPeriod'] .') AND (receives.Period' . substr($GLOBALS['LatestPeriod'],-2,2) .' = 1)
                                      GROUP BY orders.serviceID
                        ) as firstQuery
                        inner join
                        (
                        SELECT orders.serviceID, COUNT(DISTINCT pva_production.OrderId) AS CompletedDeliverables
                                    FROM   pva_production INNER JOIN 
                                             orders ON pva_production.OrderId = orders.orderID INNER JOIN 
                                               receives ON pva_production.OrderId = receives.orderID 
                                    WHERE  (orders.serviceID = ' . $GLOBALS['serviceID'] . ') AND (receives.statusID = 1) AND (pva_production.Period = ' . $GLOBALS['LatestPeriod'] .') AND (receives.Period' . substr($GLOBALS['LatestPeriod'],-2,2) .' = 1) 
                                           AND (pva_production.DatabaseStatus = "C")
                                    GROUP BY orders.serviceID
                        ) as secondQuery
                        on firstQuery.serviceID = secondQuery.serviceID');

    while($row = mssql_fetch_assoc($query))
    {                  
        $result[$GLOBALS['service']] = $row;
    }        

    return json_encode($result); 

}      

/*get CMA Clearances Info*/
function getCMAInfo(){
    $result;
    $query = mssql_query('select
                        firstQuery.TotalCMA,
                        secondQuery.CompletedCMA
                        from
                        (
                        SELECT orders.serviceID, COUNT(pva_production.OrderId) AS TotalCMA 
                                  FROM   pva_production INNER JOIN 
                                           orders ON pva_production.OrderId = orders.orderID 
                                  WHERE  (orders.serviceID = ' . $GLOBALS['serviceID'] . ') AND (pva_production.Period = ' . $GLOBALS['LatestPeriod'] .') AND (pva_production.ProductionTypeId = 1) 
                                         AND (orders.CMA = 1)
                                  GROUP BY orders.serviceID
                        ) as firstQuery
                        inner join
                        (
                        SELECT orders.serviceID, COUNT(pva_production.OrderId) AS CompletedCMA 
                                    FROM   pva_production INNER JOIN 
                                             orders ON pva_production.OrderId = orders.orderID 
                                    WHERE  (orders.serviceID = ' . $GLOBALS['serviceID'] . ') AND (pva_production.Period = ' . $GLOBALS['LatestPeriod'] .') AND (pva_production.ProductionTypeId = 1) 
                                           AND (orders.CMA = 1) AND (pva_production.Cleared=1)
                                    GROUP BY orders.serviceID
                        ) as secondQuery
                        on firstQuery.serviceID = secondQuery.serviceID');

    while($row = mssql_fetch_assoc($query))
    {            
        $result[$GLOBALS['service']] = $row;
    }

    return json_encode($result); 

}      

/*get Reworks Info*/
function getReworksInfo(){
    $result;
    $query = mssql_query('select
                                firstQuery.TotalReworks,
                                secondQuery.CompletedReworks
                                from
                                (
                                    SELECT   orders.serviceID, COUNT(pva_production.OrderId) AS TotalReworks 
                                            FROM     pva_production INNER JOIN 
                                                        orders ON pva_production.OrderId = orders.orderID 
                                            WHERE    (orders.serviceID = ' . $GLOBALS['serviceID'] . ') AND (pva_production.NumPeriods > 1) 
                                            and   (pva_production.Period = ' . $GLOBALS['LatestPeriod'] .') AND (pva_production.ProductionTypeId = 1)
                                            GROUP BY orders.serviceID
                                ) as firstQuery
                                inner join
                                (
                                SELECT   orders.serviceID, COUNT(pva_production.OrderId) AS CompletedReworks
                                            FROM     pva_production INNER JOIN 
                                                        orders ON pva_production.OrderId = orders.orderID 
                                            WHERE    (orders.serviceID = ' . $GLOBALS['serviceID'] . ') AND (pva_production.NumPeriods > 1) 
                                            and   (pva_production.Period = ' . $GLOBALS['LatestPeriod'] .') AND (pva_production.ProductionTypeId = 1)
                                                    AND (DatabaseStatus="C")
                                            GROUP BY orders.serviceID
                                ) as secondQuery
                                on firstQuery.serviceID = secondQuery.serviceID');

    while($row = mssql_fetch_assoc($query))
    {            
        $result[$GLOBALS['serviceID']] = $row;
    }

    return json_encode($result); 

}   

/*get databases in queue*/
function getDatabasesInQueueInfo(){
  $result;
  $query = mssql_query('SELECT OrderNumber, Priority, IsecJobStatus, BuildStatus, DownloadStatus
                        FROM pva_production
                        INNER JOIN orders
                        ON pva_production.OrderId = orders.orderID
                        WHERE orders.serviceID = ' . $GLOBALS['serviceID'] . ' AND Period = ' . $GLOBALS['LatestPeriod'] .'
                        AND (IsecJobStatus = "W" OR BuildStatus = "W" OR DownloadStatus = "W")
                        ORDER BY Priority');

  while($row = mssql_fetch_assoc($query))
  {
    $result[] = $row;
  }

    return json_encode($result); 

}

/*get databases being produced*/
function getDatabasesBeingProducedInfo(){
  $result;
  $query = mssql_query('SELECT OrderNumber, ServerName, IsecJobStatus, BuildStatus, DownloadStatus
                        FROM pva_production
                        INNER JOIN orders
                        ON pva_production.OrderId = orders.orderID
                        WHERE orders.serviceID = ' . $GLOBALS['serviceID'] . ' AND Period = ' . $GLOBALS['LatestPeriod'] .'
                        AND (IsecJobStatus = "R" OR BuildStatus = "R" OR DownloadStatus = "R")');

  while($row = mssql_fetch_assoc($query))
  {
    $result[] = $row;
  }

    return json_encode($result); 

}

/*get databases in queue total*/
function getDatabasesInQueueTotal(){
  $result;
  $query = mssql_query('SELECT PvaProdId, service, OrderNumber, NumPeriods, Priority, IsecJobStatus, BuildStatus, DownloadStatus
                        FROM pva_production
                        INNER JOIN orders
                        ON pva_production.OrderId = orders.orderID
                        INNER JOIN service
                        ON orders.serviceID = service.serviceID
                        WHERE Period = ' . $GLOBALS['LatestPeriod'] .'
                        AND (IsecJobStatus = "C" OR BuildStatus = "C" OR DownloadStatus = "C")
                        ORDER BY Priority');

  while($row = mssql_fetch_assoc($query))
  {
    $result[] = $row;
  }

    return json_encode($result); 

}

if(isset($_POST['action']) && !empty($_POST['action'])) {
    if(isset($_POST['service']) && !empty($_POST['service'])) {
      $GLOBALS['service'] = $_POST['service'];
    } else {
      $GLOBALS['service'] = "Worldpanel";
    }
    fillVars();
    fillIntervals();
    $action = $_POST['action'];
    switch($action) {
        case 'getAdminServerStatus' : echo getAdminServerStatus();break;
        case 'getNrServersActive' : echo getNrServersActive();break;
        case 'getNrServersOnStandby' : echo getNrServersOnStandby();break;
        case 'getNrServersInactive' : echo getNrServersInactive();break;
        case 'getAdminServerInfo' : echo getServersInfo();break;
        case 'getServersInfo' : echo getServersInfo();break;        
        case 'getNrCriticalEvents' : echo getNrEvents("16");break;
        case 'getNrWarningEvents' : echo getNrEvents("48");break;
        case 'getNrInformationEvents' : echo getNrEvents("64");break;
        case 'getNrTotalEvents' : echo getNrTotalEvents();break;
        case 'getDatabasesInfo' : echo getDatabasesInfo($_POST['service']);break;
        case 'getDeliverablesInfo' : echo getDeliverablesInfo();break;
        case 'getCMAInfo' : echo getCMAInfo();break;        
        case 'getReworksInfo' : echo getReworksInfo();break;   
        case 'getDatabasesInQueueInfo' : echo getDatabasesInQueueInfo();break;
        case 'getDatabasesBeingProducedInfo' : echo getDatabasesBeingProducedInfo();break;
        case 'getDatabasesInQueueTotal' : echo getDatabasesInQueueTotal();break;
    }
}

/*
fillVars();
fillIntervals();
echo getDatabasesInQueueTotal();
*/

?>
<?php

include 'conn_database.php';

/*fill serviceID & latest period*/
$GLOBALS['service'] = "Worldpanel";//$_POST['service'];
$GLOBALS['services'] = array('Worldpanel', 'Food On The Go', 'Worldpanel Ireland', 'Combined Panel', 'Petrol Panel', 'Foods Online', 'Pulse');
$GLOBALS['serviceID'] = "";
$GLOBALS['servicesIDs'] = array();
$GLOBALS['LatestPeriod'] = "";

/*fill vars for 1 service*/
function fillVars(){
    $query = sqlsrv_query($GLOBALS['conn'], "SELECT serviceID, service, ServiceName, LatestPeriod From Service WHERE (LatestPeriod IS NOT NULL) AND service like '". $GLOBALS['service'] ."' ORDER BY pvaDisplaySequence");
    
    $row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    $GLOBALS['serviceID'] = $row["serviceID"];    
    $GLOBALS['LatestPeriod'] = $row["LatestPeriod"];    
}

/*fill intervals*/
$GLOBALS['intervals'] = array(0, 8, 16, 24, 32, 40, 48);
function fillIntervals(){
        
    $query = sqlsrv_query($GLOBALS['conn'], "select MIN(PrepDate) AS Date
              FROM   pva_production INNER JOIN 
              orders ON pva_production.OrderId = orders.orderID 
              WHERE  (pva_production.ProductionTypeId=1) AND (orders.serviceID = " . $GLOBALS['serviceID'] . ") AND (pva_production.Period = " . $GLOBALS['LatestPeriod'] . ")");    


    $row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    $now = date("Y-m-d H:i:s");
    $hourdiff = round((strtotime($now) - strtotime($row["Date"]->format('m/d/Y')))/3600, 2);
    $diffIntervals = round($hourdiff/6, 0);
    $GLOBALS['intervals'] = array(0, $diffIntervals*1, $diffIntervals*2, $diffIntervals*3, $diffIntervals*4, $diffIntervals*5, ($diffIntervals*6)-1);    
    
}

/*Admin server status*/
function getAdminServerStatus(){
    $result;
    $query = sqlsrv_query($GLOBALS['conn'], "SELECT pva_server.ServerId, pva_server.pvaStatusId, pva_server.ServerName, pva_mode.pvaMode, pva_serverstatus.pvaStatus,
                        DATEADD(hour, DATEDIFF(hour, getutcdate(), GETDATE()), pva_server.LastTimeCheck) AS LastTimeCheck, 
                        DATEADD(hour, DATEDIFF(hour, getutcdate(), GETDATE()), pva_server.NextPvDemon) AS NextPvDemon, 
                        DATEADD(hour, DATEDIFF(hour, getutcdate(), GETDATE()), pva_server.NextPvJobSub) AS NextPvJobSub, 
                        DATEADD(hour, DATEDIFF(hour, getutcdate(), GETDATE()), pva_server.NextPvDownload) AS NextPvDownload
                        FROM pva_server INNER JOIN
                        pva_mode ON pva_server.pvaModeId = pva_mode.pvaModeId INNER JOIN
                        pva_serverstatus ON pva_server.pvaStatusId = pva_serverstatus.pvaStatusId
                        WHERE (pva_server.pvaModeId = 1) 
                        ORDER BY pva_server.DisplaySequence, pva_server.ServerName");
    
    while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
        $result = $row;
    }
    return json_encode($result);   
}

/*Number of active servers*/
function getNrServersActive(){
    $query = sqlsrv_query($GLOBALS['conn'], "select Count (*) from [PowerView].[powerview].[pva_server]
  					      where pvaModeId=2 and pvaStatusID = 2");    
    
    $row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    if ($row[""] > 0) {
      return $row[""];
    } else {
      return 0;
    }    
}

/*Number of standby servers*/
function getNrServersOnStandby(){
    $query = sqlsrv_query($GLOBALS['conn'], "select Count (*) from [PowerView].[powerview].[pva_server]
  					      where pvaModeId=2 and pvaStatusID = 3");    
    
    $row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    if ($row[""] > 0) {
      return $row[""];
    } else {
      return 0;
    }
}

/*Number of inactive servers*/
function getNrServersInactive(){
    $query = sqlsrv_query($GLOBALS['conn'],"select Count (*) from [PowerView].[powerview].[pva_server]
  					      where pvaModeId=0 and pvaStatusID = 0 and ProductionStatus = 1");    
    
    $row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    if ($row[""] > 0) {
      return $row[""];
    } else {
      return 0;
    }
}

/*get Admin Server Info*/
function getAdminServerInfo(){
    $result;
    $query = sqlsrv_query($GLOBALS['conn'], "SELECT pva_server.ServerName, pva_mode.pvaMode, pva_serverstatus.pvaStatus, pva_server.LastTimeCheck, pva_production.OrderNumber,
                    pva_production.DataPeriod, pva_production.NumPeriods, pva_production.BuildMode, pva_server.ServerId, pva_server.pvaStatusId,
                    pva_production.StatusDescription, pva_order_prodn.AverageBuildTime,
                    DATEADD(hour, DATEDIFF(hour, getutcdate(), GETDATE()), pva_production.BuildTimeStart) AS BuildTimeStart
                    FROM      pva_server INNER JOIN
                    pva_mode ON pva_server.pvaModeId = pva_mode.pvaModeId INNER JOIN
                    pva_serverstatus ON pva_server.pvaStatusId = pva_serverstatus.pvaStatusId LEFT OUTER JOIN
                    pva_production ON pva_server.PvaProdId = pva_production.PvaProdId LEFT OUTER JOIN
                    pva_order_prodn ON pva_production.OrderId = pva_order_prodn.OrderId
                    WHERE     (pva_server.pvaModeId = 2) OR ((pva_server.ProductionStatus=1) AND (pva_server.pvaModeId <> 1))
                    ORDER BY  pva_server.DisplaySequence, pva_server.ServerName");
    
    while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
        $result = $row;
    }
    return json_encode($result); 
}

/*get Admin Server Info*/
function getServersInfo(){
    $result = [];
    $query = sqlsrv_query($GLOBALS['conn'], "SELECT     pva_server.ServerName, pva_mode.pvaMode, pva_serverstatus.pvaStatus, pva_server.LastTimeCheck, pva_production.OrderNumber, 
                               pva_production.DataPeriod, pva_production.NumPeriods, pva_production.BuildMode, pva_server.ServerId, pva_server.pvaStatusId, 
                               pva_production.StatusDescription, pva_order_prodn.AverageBuildTime, 
                               DATEADD(hour, DATEDIFF(hour, getutcdate(), GETDATE()), pva_production.BuildTimeStart) AS BuildTimeStart 
                     FROM      pva_server INNER JOIN 
                               pva_mode ON pva_server.pvaModeId = pva_mode.pvaModeId INNER JOIN 
                               pva_serverstatus ON pva_server.pvaStatusId = pva_serverstatus.pvaStatusId LEFT OUTER JOIN 
                               pva_production ON pva_server.PvaProdId = pva_production.PvaProdId LEFT OUTER JOIN 
                               pva_order_prodn ON pva_production.OrderId = pva_order_prodn.OrderId 
                     WHERE     (pva_server.pvaModeId = 2) OR ((pva_server.ProductionStatus=1) AND (pva_server.pvaModeId <> 1))
                     ORDER BY  pva_server.DisplaySequence, pva_server.ServerName");
     
    while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
        $result[] = $row;
    }
    return json_encode($result); 
}

/*get Active Servers per hour last 24 hours*/
function getServersPerHour(){
    $result = [];
    $query = sqlsrv_query($GLOBALS['conn'], "select count(DISTINCT t.ServerName), t.Hour
                          from (select ServerName, dateadd(HH, datediff(HH,0, BuildTimeStart), 0) As Hour
                          from pva_production
                          where period = 201508 and BuildTimeStart > dateadd(HH, -24, getdate())
                          union all
                          select ServerName, dateadd(HH, datediff(HH, 0, dateadd(ss, BuildSeconds, BuildTimeStart)), 0) as Hour
                          from pva_production
                          where period = " . $row1['LatestPeriod'] . " and BuildTimeStart > dateadd(HH, -24, getdate())) t
                          Group By t.Hour");
     
    while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
        $result[] = $row;
    }
    return json_encode($result); 
}

/* Nr of events by level last 4 weeks*/
function getNrEvents($level){
    $query = sqlsrv_query($GLOBALS['conn'], "SELECT COUNT(pvaEventId)
                    FROM       pva_eventlog 
                    WHERE     (ClearedBy IS NULL) AND (Severity=" . $level . ") 
                    GROUP BY   Severity");    
    
    $row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    if ($row[""] > 0) {
      return $row[""];
    } else {
      return 0;
    }
    
}

/* Nr total of events last 4 weeks*/
function getNrTotalEvents(){
    $query = sqlsrv_query($GLOBALS['conn'], "SELECT COUNT(pvaEventId)
                    FROM       pva_eventlog 
                    WHERE     (ClearedBy IS NULL)");
    
    $row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    if ($row[""] > 0) {
      return $row[""];
    } else {
      return 0;
    }
}

/* get events */
function getEvents($level){
    $result = [];
    $query = sqlsrv_query($GLOBALS['conn'], "SELECT *
                        FROM       pva_eventlog
                        WHERE     (ClearedBy IS NULL) AND (Severity=" . $level . ")");
    
    while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
        $result[] = $row;
    }
    return json_encode($result); 
}

/* Total events */
function getTotalEvents(){
    $result = [];
    $query = sqlsrv_query($GLOBALS['conn'], "SELECT *
                        FROM       pva_eventlog
                        WHERE     (ClearedBy IS NULL)");
    
    while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
        $result[] = $row;
    }
    return json_encode($result); 
}

/*clear events in pva_eventlog*/
function clearEvents($pvaEventIds){
  
  $query = sqlsrv_query($GLOBALS['conn'], "UPDATE pva_eventlog 
                        SET ClearedBy= '" . $_SERVER['REMOTE_USER'] . "', ClearedWhen= '" . date('Y-m-d H:i:s') . "'
                        WHERE pvaEventId IN (" . implode(',', $pvaEventIds) . ")");

  return true;

}

/*get Databases Info V1*/
/*original version, not being used at the moment, could be at the future, keep*/
function getDatabasesInfoV1(){
    $query1 = sqlsrv_query($GLOBALS['conn'], "SELECT serviceID, service, ServiceName, LatestPeriod From Service WHERE (LatestPeriod IS NOT NULL) ORDER BY pvaDisplaySequence");
    $result = [];
    while($row1 = sqlsrv_fetch_array($query1, SQLSRV_FETCH_ASSOC))
    {                
        $query2 = sqlsrv_query($GLOBALS['conn'], "select
                            firstQuery.TotalDatabases,
                            secondQuery.CompletedDatabases
                            from
                            (
                                SELECT orders.serviceID, count(pva_production.OrderId) AS TotalDatabases, pva_production.ProductionTypeId
                                      FROM   pva_production INNER JOIN 
                                             orders ON pva_production.OrderId = orders.orderID 
                                      WHERE (pva_production.ProductionTypeId=1) AND (orders.serviceID = " . $row1['serviceID'] . ") AND (pva_production.Period = " . $row1['LatestPeriod'] .")
                                      GROUP BY orders.serviceID, pva_production.ProductionTypeId
                            ) as firstQuery
                            inner join
                            (
                            SELECT orders.serviceID, COUNT(pva_production.OrderId) AS CompletedDatabases, pva_production.ProductionTypeId
                                      FROM   pva_production INNER JOIN 
                                             orders ON pva_production.OrderId = orders.orderID 
                                      WHERE (pva_production.ProductionTypeId=1) AND (orders.serviceID = " . $row1['serviceID'] . ") AND (pva_production.Period = " . $row1['LatestPeriod'] .")
                                             AND (DatabaseStatus='C')
                                      GROUP BY orders.serviceID, pva_production.ProductionTypeId
                            ) as secondQuery
                            on firstQuery.ProductionTypeId = secondQuery.ProductionTypeId");

        while($row2 = sqlsrv_fetch_array($query2, SQLSRV_FETCH_ASSOC))
        {            
            $result[$row1["service"]] = $row2;
        }    
    }

    return json_encode($result); 

}

/*get Databases Info Main*/
function getDatabasesInfoMain(){
    $result = [];
    $query = sqlsrv_query($GLOBALS['conn'], "select
                        firstQuery.serviceID,
                        firstQuery.service,
                        firstQuery.LatestPeriod,
                        firstQuery.TotalDatabases,
                        secondQuery.CompletedDatabases
                        from
                        (
                            SELECT orders.serviceID, service.service, service.LatestPeriod, count(pva_production.OrderId) AS TotalDatabases
                                    FROM   pva_production INNER JOIN 
                                            orders ON pva_production.OrderId = orders.orderID 
                                INNER JOIN service 
                                ON orders.serviceID = service.serviceID 
                                    WHERE (pva_production.ProductionTypeId=1) AND (service.LatestPeriod IS NOT NULL) AND (service.LatestPeriod = pva_production.Period)
                                    GROUP BY orders.serviceID, service.service, service.LatestPeriod
                        ) as firstQuery
                        inner join
                        (
                        SELECT orders.serviceID, COUNT(pva_production.OrderId) AS CompletedDatabases
                                    FROM   pva_production INNER JOIN 
                                            orders ON pva_production.OrderId = orders.orderID 
                                INNER JOIN service 
                                ON orders.serviceID = service.serviceID 
                                    WHERE (pva_production.ProductionTypeId=1) AND (service.LatestPeriod IS NOT NULL) AND (service.LatestPeriod = pva_production.Period)
                                            AND (DatabaseStatus='C')
                                    GROUP BY orders.serviceID
                        ) as secondQuery              
                      on firstQuery.serviceID = secondQuery.serviceID");


    while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {              
      $result[] = $row;
    }      

    return json_encode($result);
}

/*get Databases Info test version 3*/
function getDatabasesInfo($service){
    $result = [];      
    foreach ($GLOBALS['intervals'] as $interval){
        $date = date("Y-m-d H:i:s", strtotime('-'. $interval .' hour'));
        $query = sqlsrv_query($GLOBALS['conn'], "select
                            firstQuery.TotalDatabases,
                            secondQuery.CompletedDatabases,
                            thirdQuery.DownloadedDatabases,
                            ".$interval." AS hours
                            from
                            (
                                SELECT orders.serviceID, count(pva_production.OrderId) AS TotalDatabases
                                      FROM   pva_production INNER JOIN 
                                             orders ON pva_production.OrderId = orders.orderID 
                                      WHERE (pva_production.ProductionTypeId=1) AND (orders.serviceID = " . $GLOBALS['serviceID'] . ") AND (pva_production.Period = " . $GLOBALS['LatestPeriod'] . ") AND (pva_production.DatabaseDate < '" . $date . "' or pva_production.DatabaseDate = NULL)
                                      GROUP BY orders.serviceID, pva_production.ProductionTypeId
                            ) as firstQuery
                            left join
                            (
                            SELECT orders.serviceID, COUNT(pva_production.OrderId) AS CompletedDatabases
                                      FROM   pva_production INNER JOIN 
                                             orders ON pva_production.OrderId = orders.orderID 
                                      WHERE (pva_production.ProductionTypeId=1) AND (orders.serviceID = " . $GLOBALS['serviceID'] . ") AND (pva_production.Period = " . $GLOBALS['LatestPeriod'] . ") AND (pva_production.DatabaseDate < '" . $date . "')
                                             AND (DatabaseStatus='C')
                                      GROUP BY orders.serviceID, pva_production.ProductionTypeId
                            ) as secondQuery 
                            on firstQuery.serviceID = secondQuery.serviceID                               
                            left join
                            (
                            SELECT ServiceId, COUNT(*) AS DownloadedDatabases
                                      FROM   FtpDeliveryEmails
                                      WHERE ServiceId = " . $GLOBALS['serviceID'] . " and Period = " . $GLOBALS['LatestPeriod'] ." and SentDate< '". $date ."'
                                      Group By ServiceId                                  
                            ) as thirdQuery
                            on firstQuery.serviceID = thirdQuery.serviceID");

        while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
        {                  
            $result[$GLOBALS['service']."-".array_search($interval, $GLOBALS['intervals'])] = $row;
        }    
    }


    return json_encode($result); 

}

/*get Deliverable Databases Info*/
function getDeliverablesInfo(){
    $result = [];
    $query = sqlsrv_query($GLOBALS['conn'], "select
                        firstQuery.TotalDeliverables,
                        secondQuery.CompletedDeliverables
                        from
                        (
                            SELECT orders.serviceID, COUNT(DISTINCT pva_production.OrderId) AS TotalDeliverables
                                      FROM   pva_production INNER JOIN 
                                               orders ON pva_production.OrderId = orders.orderID INNER JOIN 
                                                 receives ON pva_production.OrderId = receives.orderID 
                                      WHERE  (orders.serviceID = " . $GLOBALS['serviceID'] . ") AND (receives.statusID = 1) AND (pva_production.Period = " . $GLOBALS['LatestPeriod'] . ") AND (receives.Period" . substr($GLOBALS['LatestPeriod'],-2,2) ." = 1)
                                      GROUP BY orders.serviceID
                        ) as firstQuery
                        inner join
                        (
                        SELECT orders.serviceID, COUNT(DISTINCT pva_production.OrderId) AS CompletedDeliverables
                                    FROM   pva_production INNER JOIN 
                                             orders ON pva_production.OrderId = orders.orderID INNER JOIN 
                                               receives ON pva_production.OrderId = receives.orderID 
                                    WHERE  (orders.serviceID = " . $GLOBALS['serviceID'] . ") AND (receives.statusID = 1) AND (pva_production.Period = " . $GLOBALS['LatestPeriod'] .") AND (receives.Period" . substr($GLOBALS['LatestPeriod'],-2,2) . " = 1) 
                                           AND (pva_production.DatabaseStatus = 'C')
                                    GROUP BY orders.serviceID
                        ) as secondQuery
                        on firstQuery.serviceID = secondQuery.serviceID");

    while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {                  
        $result[$GLOBALS['service']] = $row;
    }        

    return json_encode($result); 

}      

/*get Deliverables Info Main*/
function getDeliverablesInfoMain(){
    $query1 = sqlsrv_query($GLOBALS['conn'], "SELECT serviceID, service, ServiceName, LatestPeriod, SUBSTRING(LatestPeriod, 5, 2) AS MonthPeriod FROM Service WHERE LatestPeriod IS NOT NULL");
    ////////////////////////////////////////////////////////UNFINISHED/////////////////////////////////////////////////////////////////////////
    $result = [];
    while($row1 = sqlsrv_fetch_array($query1, SQLSRV_FETCH_ASSOC))
    {
      $query2 = sqlsrv_query($GLOBALS['conn'], "select
                          firstQuery.serviceID,
                          firstQuery.service,
                          firstQuery.LatestPeriod,
                          firstQuery.TotalDeliverables,
                          secondQuery.CompletedDeliverables
                          from
                          (
                              SELECT orders.serviceID, service.service, service.LatestPeriod, count(DISTINCT pva_production.OrderId) AS TotalDeliverables
                                      FROM   pva_production INNER JOIN 
                                              orders ON pva_production.OrderId = orders.orderID  INNER JOIN 
                                                 receives ON pva_production.OrderId = receives.orderID 
                                                  INNER JOIN service 
                                                    ON orders.serviceID = service.serviceID 
                                      WHERE (pva_production.ProductionTypeId=1) AND (orders.serviceID = " . $row1['serviceID'] . ") AND (pva_production.Period = " . $row1['LatestPeriod'] . ") AND (receives.Period" . $row1['MonthPeriod'] ." = 1)
                                      GROUP BY orders.serviceID, service.service, service.LatestPeriod
                          ) as firstQuery
                          inner join
                          (
                          SELECT orders.serviceID, COUNT(DISTINCT pva_production.OrderId) AS CompletedDeliverables
                                      FROM   pva_production INNER JOIN 
                                              orders ON pva_production.OrderId = orders.orderID  INNER JOIN 
                                               receives ON pva_production.OrderId = receives.orderID
                                      WHERE (orders.serviceID = " . $row1['serviceID'] . ") AND (receives.statusID = 1) AND (pva_production.Period = " . $row1['LatestPeriod'] .") AND (receives.Period" . $row1['MonthPeriod'] . " = 1) 
                                           AND (pva_production.DatabaseStatus = 'C')
                                      GROUP BY orders.serviceID
                          ) as secondQuery              
                        on firstQuery.serviceID = secondQuery.serviceID");

if( $query2 === false ) {
    if( ($errors = sqlsrv_errors() ) != null) {
        foreach( $errors as $error ) {
            echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
            echo "code: ".$error[ 'code']."<br />";
            echo "message: ".$error[ 'message']."<br />";
        }
    }
  }

      while($row2 = sqlsrv_fetch_array($query2, SQLSRV_FETCH_ASSOC))
      {              
        $result[] = $row2;
      }      
    }

    return json_encode($result);
}

/*get CMA Clearances Info*/
function getCMAInfo(){
    $result = [];
    $query = sqlsrv_query($GLOBALS['conn'], "select
                        firstQuery.TotalCMA,
                        secondQuery.CompletedCMA
                        from
                        (
                        SELECT orders.serviceID, COUNT(pva_production.OrderId) AS TotalCMA 
                                  FROM   pva_production INNER JOIN 
                                           orders ON pva_production.OrderId = orders.orderID 
                                  WHERE  (orders.serviceID = " . $GLOBALS['serviceID'] . ") AND (pva_production.Period = " . $GLOBALS['LatestPeriod'] . ") AND (pva_production.ProductionTypeId = 1) 
                                         AND (orders.CMA = 1)
                                  GROUP BY orders.serviceID
                        ) as firstQuery
                        inner join
                        (
                        SELECT orders.serviceID, COUNT(pva_production.OrderId) AS CompletedCMA 
                                    FROM   pva_production INNER JOIN 
                                             orders ON pva_production.OrderId = orders.orderID 
                                    WHERE  (orders.serviceID = " . $GLOBALS['serviceID'] . ") AND (pva_production.Period = " . $GLOBALS['LatestPeriod'] .") AND (pva_production.ProductionTypeId = 1) 
                                           AND (orders.CMA = 1) AND (pva_production.Cleared=1)
                                    GROUP BY orders.serviceID
                        ) as secondQuery
                        on firstQuery.serviceID = secondQuery.serviceID");

    while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {            
        $result[$GLOBALS['service']] = $row;
    }

    return json_encode($result); 

}      

/*get CMA Info Main*/
function getCMAInfoMain(){
    $result = [];
    $query = sqlsrv_query($GLOBALS['conn'], "select
                        firstQuery.serviceID,
                        firstQuery.service,
                        firstQuery.LatestPeriod,
                        firstQuery.TotalCMA,
                        secondQuery.CompletedCMA
                        from
                        (
                            SELECT orders.serviceID, service.service, service.LatestPeriod, count(pva_production.OrderId) AS TotalCMA
                                    FROM   pva_production INNER JOIN 
                                            orders ON pva_production.OrderId = orders.orderID 
                                INNER JOIN service 
                                ON orders.serviceID = service.serviceID 
                                    WHERE (pva_production.ProductionTypeId=1) AND (service.LatestPeriod IS NOT NULL) AND (service.LatestPeriod = pva_production.Period)
                                          AND (orders.CMA = 1)
                                    GROUP BY orders.serviceID, service.service, service.LatestPeriod
                        ) as firstQuery
                        inner join
                        (
                        SELECT orders.serviceID, COUNT(pva_production.OrderId) AS CompletedCMA
                                    FROM   pva_production INNER JOIN 
                                            orders ON pva_production.OrderId = orders.orderID 
                                INNER JOIN service 
                                ON orders.serviceID = service.serviceID 
                                    WHERE (pva_production.ProductionTypeId=1) AND (service.LatestPeriod IS NOT NULL) AND (service.LatestPeriod = pva_production.Period)
                                             AND (orders.CMA = 1) AND (pva_production.Cleared=1)
                                    GROUP BY orders.serviceID
                        ) as secondQuery              
                      on firstQuery.serviceID = secondQuery.serviceID");


    while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {              
      $result[] = $row;
    }      

    return json_encode($result);
}

/*get Reworks Info*/
function getReworksInfo(){
    $result = [];
    $query = sqlsrv_query($GLOBALS['conn'], "select
                                firstQuery.TotalReworks,
                                secondQuery.CompletedReworks
                                from
                                (
                                    SELECT   orders.serviceID, COUNT(pva_production.OrderId) AS TotalReworks 
                                            FROM     pva_production INNER JOIN 
                                                        orders ON pva_production.OrderId = orders.orderID 
                                            WHERE    (orders.serviceID = " . $GLOBALS['serviceID'] . ") AND (pva_production.NumPeriods > 1) 
                                            and   (pva_production.Period = " . $GLOBALS['LatestPeriod'] .") AND (pva_production.ProductionTypeId = 1)
                                            GROUP BY orders.serviceID
                                ) as firstQuery
                                inner join
                                (
                                SELECT   orders.serviceID, COUNT(pva_production.OrderId) AS CompletedReworks
                                            FROM     pva_production INNER JOIN 
                                                        orders ON pva_production.OrderId = orders.orderID 
                                            WHERE    (orders.serviceID = " . $GLOBALS['serviceID'] . ") AND (pva_production.NumPeriods > 1) 
                                            and   (pva_production.Period = " . $GLOBALS['LatestPeriod'] .") AND (pva_production.ProductionTypeId = 1)
                                                    AND (DatabaseStatus='C')
                                            GROUP BY orders.serviceID
                                ) as secondQuery
                                on firstQuery.serviceID = secondQuery.serviceID");

    while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {            
        $result[$GLOBALS['serviceID']] = $row;
    }

    return json_encode($result); 

}   

/*get databases in queue*/
function getDatabasesInQueueInfo(){
  $result = [];
  $query = sqlsrv_query($GLOBALS['conn'], "SELECT OrderNumber, Priority, IsecJobStatus, BuildStatus, DownloadStatus
                        FROM pva_production
                        INNER JOIN orders
                        ON pva_production.OrderId = orders.orderID
                        WHERE orders.serviceID = " . $GLOBALS['serviceID'] . " AND Period = " . $GLOBALS['LatestPeriod'] ."
                        AND (IsecJobStatus = 'W' OR BuildStatus = 'W' OR DownloadStatus = 'W')
                        ORDER BY Priority");

  if( $query === false ) {
    echo "IsFalse";
    if( ($errors = sqlsrv_errors() ) != null) {
        foreach( $errors as $error ) {
            echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
            echo "code: ".$error[ 'code']."<br />";
            echo "message: ".$error[ 'message']."<br />";
        }
    }
  }

  while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
  {
    $result[] = $row;
  }

    return json_encode($result); 

}

/*get databases being produced*/
function getDatabasesBeingProducedInfo(){
  $result = [];
  $query = sqlsrv_query($GLOBALS['conn'], "SELECT OrderNumber, ServerName, IsecJobStatus, BuildStatus, DownloadStatus
                        FROM pva_production
                        INNER JOIN orders
                        ON pva_production.OrderId = orders.orderID
                        WHERE orders.serviceID = " . $GLOBALS['serviceID'] . " AND Period = " . $GLOBALS['LatestPeriod'] . "
                        AND (IsecJobStatus = 'R' OR BuildStatus = 'R' OR DownloadStatus = 'R')");

  while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
  {
    $result[] = $row;
  }

    return json_encode($result); 

}

/*get databases in queue total*/
function getDatabasesInQueueTotal(){
  $result = [];
  $query = sqlsrv_query($GLOBALS['conn'], "SELECT PvaProdId, service, OrderNumber, NumPeriods, Priority, IsecJobStatus, BuildStatus, DownloadStatus 
                        FROM pva_production 
                        INNER JOIN orders 
                        ON pva_production.OrderId = orders.orderID 
                        INNER JOIN service 
                        ON orders.serviceID = service.serviceID 
                        WHERE Period = " . $GLOBALS['LatestPeriod'] ." ");
                        /*AND (IsecJobStatus = 'C' OR BuildStatus = 'C' OR DownloadStatus = 'C') 
                        ORDER BY Priority");*/

  /*Useful code, show's you the errors if the query fails*/
  /*if( $query === false ) {
    if( ($errors = sqlsrv_errors() ) != null) {
        foreach( $errors as $error ) {
            echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
            echo "code: ".$error[ 'code']."<br />";
            echo "message: ".$error[ 'message']."<br />";
        }
    }
  }*/

  while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
  {
    $result[] = $row;
  }

    return json_encode($result); 

}

/*get queue info*/
function getQueueInfo(){
  $result = [];
  $query = sqlsrv_query($GLOBALS['conn'], "SELECT service, BuildStatus, COUNT(*) as Nr
                        FROM pva_production 
                        INNER JOIN orders
                        ON pva_production.OrderId = orders.orderID 
                        INNER JOIN service
                        ON orders.serviceID = service.serviceID 
                        WHERE Period = " . $GLOBALS['LatestPeriod'] . "
                        GROUP BY service, BuildStatus");

  /*Useful code, show's you the errors if the query fails*/
  if( $query === false ) {
    if( ($errors = sqlsrv_errors() ) != null) {
        foreach( $errors as $error ) {
            echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
            echo "code: ".$error[ 'code']."<br />";
            echo "message: ".$error[ 'message']."<br />";
        }
    }
  }

  while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
  { 
    $result[] = $row;
  }

    return json_encode($result); 

}

/*update priority in pva_production*/
function updatePriority($priority, $pvaProdIds){
  
  $query = sqlsrv_query($GLOBALS['conn'], "UPDATE pva_production
                        SET Priority= " . $priority . "
                        WHERE Period = " . $GLOBALS['LatestPeriod'] ." AND PvaProdId IN (" . implode(',', $pvaProdIds) . ")");

  return true;

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
        case 'getAdminServerInfo' : echo getAdminServerInfo();break;
        case 'getServersInfo' : echo getServersInfo();break;        
        case 'getNrCriticalEvents' : echo getNrEvents("16");break;
        case 'getNrWarningEvents' : echo getNrEvents("48");break;
        case 'getNrInformationEvents' : echo getNrEvents("64");break;
        case 'getNrTotalEvents' : echo getNrTotalEvents();break;
        case 'getTotalEvents' : echo getTotalEvents();break; 
        case 'getEvents' : echo getEvents($_POST['severity']);break;                
        case 'clearEvents' : echo clearEvents($_POST['ids']);break;
        case 'getDatabasesInfo' : echo getDatabasesInfo($_POST['service']);break;
        case 'getDeliverablesInfo' : echo getDeliverablesInfo();break;
        case 'getCMAInfo' : echo getCMAInfo();break;        
        case 'getReworksInfo' : echo getReworksInfo();break;   
        case 'getDatabasesInQueueInfo' : echo getDatabasesInQueueInfo();break;
        case 'getDatabasesBeingProducedInfo' : echo getDatabasesBeingProducedInfo();break;
        case 'getDatabasesInQueueTotal' : echo getDatabasesInQueueTotal();break;
        case 'getDatabasesInfoMain' : echo getDatabasesInfoMain();break;
        case 'getDeliverablesInfoMain' : echo getDeliverablesInfoMain();break;
        case 'getCMAInfoMain' : echo getCMAInfoMain();break;
        case 'getQueueInfo' : echo getQueueInfo();break;
        case 'updatePriority' : echo updatePriority($_POST['priority'], $_POST['ids']);break;        
    }
}

/* Test code to show results by calling db/queries.php */
/*
fillVars();
fillIntervals();
echo getAdminServerStatus();
echo getNrServersActive();
echo getNrServersOnStandby();
echo getNrServersInactive();
echo getAdminServerInfo();
echo getServersInfo();
echo getNrEvents("16");
echo getNrTotalEvents();
echo getDatabasesInfo("Worldpanel");
echo getDeliverablesInfo();
echo getCMAInfo();
echo getReworksInfo();
echo getDatabasesInQueueInfo();
echo getDatabasesBeingProducedInfo();
echo getDatabasesInQueueTotal();
*/


?>
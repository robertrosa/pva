  sql = "SELECT        pva_server.ServerId, pva_server.pvaStatusId, pva_server.ServerName, pva_mode.pvaMode, pva_serverstatus.pvaStatus, " &_
				"              DATEADD(hour, DATEDIFF(hour, getutcdate(), GETDATE()), pva_server.LastTimeCheck) AS LastTimeCheck, " &_
        "              DATEADD(hour, DATEDIFF(hour, getutcdate(), GETDATE()), pva_server.NextPvDemon) AS NextPvDemon, " &_
        "              DATEADD(hour, DATEDIFF(hour, getutcdate(), GETDATE()), pva_server.NextPvJobSub) AS NextPvJobSub, " &_
        "              DATEADD(hour, DATEDIFF(hour, getutcdate(), GETDATE()), pva_server.NextPvDownload) AS NextPvDownload " &_
        " FROM         pva_server INNER JOIN" &_
        "              pva_mode ON pva_server.pvaModeId = pva_mode.pvaModeId INNER JOIN" &_
        "              pva_serverstatus ON pva_server.pvaStatusId = pva_serverstatus.pvaStatusId" &_
        " WHERE       (pva_server.pvaModeId = 1) " &_
        " ORDER BY     pva_server.DisplaySequence, pva_server.ServerName"


/* Get master server info */
SELECT pva_server.ServerId, pva_server.pvaStatusId, pva_server.ServerName, pva_mode.pvaMode, pva_serverstatus.pvaStatus,
DATEADD(hour, DATEDIFF(hour, getutcdate(), GETDATE()), pva_server.LastTimeCheck) AS LastTimeCheck, 
DATEADD(hour, DATEDIFF(hour, getutcdate(), GETDATE()), pva_server.NextPvDemon) AS NextPvDemon, 
DATEADD(hour, DATEDIFF(hour, getutcdate(), GETDATE()), pva_server.NextPvJobSub) AS NextPvJobSub, 
DATEADD(hour, DATEDIFF(hour, getutcdate(), GETDATE()), pva_server.NextPvDownload) AS NextPvDownload
FROM pva_server INNER JOIN
pva_mode ON pva_server.pvaModeId = pva_mode.pvaModeId INNER JOIN
pva_serverstatus ON pva_server.pvaStatusId = pva_serverstatus.pvaStatusId
WHERE (pva_server.pvaModeId = 1) 
ORDER BY pva_server.DisplaySequence, pva_server.ServerName



  sql = "SELECT     pva_server.ServerName, pva_mode.pvaMode, pva_serverstatus.pvaStatus, pva_server.LastTimeCheck, pva_production.OrderNumber, " &_
        "           pva_production.DataPeriod, pva_production.NumPeriods, pva_production.BuildMode, pva_server.ServerId, pva_server.pvaStatusId, " &_
        "           pva_production.StatusDescription, pva_order_prodn.AverageBuildTime, " &_
        "           DATEADD(hour, DATEDIFF(hour, getutcdate(), GETDATE()), pva_production.BuildTimeStart) AS BuildTimeStart " &_
        " FROM      pva_server INNER JOIN " &_
        "           pva_mode ON pva_server.pvaModeId = pva_mode.pvaModeId INNER JOIN " &_
        "           pva_serverstatus ON pva_server.pvaStatusId = pva_serverstatus.pvaStatusId LEFT OUTER JOIN " &_
        "           pva_production ON pva_server.PvaProdId = pva_production.PvaProdId LEFT OUTER JOIN " &_
        "           pva_order_prodn ON pva_production.OrderId = pva_order_prodn.OrderId " &_
        " WHERE     (pva_server.pvaModeId = 2) OR ((pva_server.ProductionStatus=1) AND (pva_server.pvaModeId <> 1))" &_
        " ORDER BY  pva_server.DisplaySequence, pva_server.ServerName"

/* Get servers info */
SELECT pva_server.ServerName, pva_mode.pvaMode, pva_serverstatus.pvaStatus, pva_server.LastTimeCheck, pva_production.OrderNumber,
pva_production.DataPeriod, pva_production.NumPeriods, pva_production.BuildMode, pva_server.ServerId, pva_server.pvaStatusId,
pva_production.StatusDescription, pva_order_prodn.AverageBuildTime,
DATEADD(hour, DATEDIFF(hour, getutcdate(), GETDATE()), pva_production.BuildTimeStart) AS BuildTimeStart
FROM      pva_server INNER JOIN
pva_mode ON pva_server.pvaModeId = pva_mode.pvaModeId INNER JOIN
pva_serverstatus ON pva_server.pvaStatusId = pva_serverstatus.pvaStatusId LEFT OUTER JOIN
pva_production ON pva_server.PvaProdId = pva_production.PvaProdId LEFT OUTER JOIN
pva_order_prodn ON pva_production.OrderId = pva_order_prodn.OrderId
WHERE     (pva_server.pvaModeId = 2) OR ((pva_server.ProductionStatus=1) AND (pva_server.pvaModeId <> 1))
ORDER BY  pva_server.DisplaySequence, pva_server.ServerName


  sql = "SELECT        pva_server.ServerId, pva_server.pvaStatusId, pva_server.ServerName, pva_mode.pvaMode, pva_serverstatus.pvaStatus, pva_server.LastTimeCheck, " &_
        "              pva_server.NextPvDemon, pva_server.NextPvJobSub, pva_server.NextPvDownload" &_
        " FROM         pva_server INNER JOIN" &_
        "              pva_mode ON pva_server.pvaModeId = pva_mode.pvaModeId INNER JOIN" &_
        "              pva_serverstatus ON pva_server.pvaStatusId = pva_serverstatus.pvaStatusId" &_
        " WHERE       (pva_server.pvaModeId = 1) AND (ProductionStatus=1)" &_
        " ORDER BY     pva_server.DisplaySequence, pva_server.ServerName"

/* Get master server info another option??? */
SELECT pva_server.ServerId, pva_server.pvaStatusId, pva_server.ServerName, pva_mode.pvaMode, pva_serverstatus.pvaStatus, pva_server.LastTimeCheck, 
pva_server.NextPvDemon, pva_server.NextPvJobSub, pva_server.NextPvDownload 
FROM pva_server INNER JOIN 
pva_mode ON pva_server.pvaModeId = pva_mode.pvaModeId INNER JOIN 
pva_serverstatus ON pva_server.pvaStatusId = pva_serverstatus.pvaStatusId 
WHERE (pva_server.pvaModeId = 1) AND (ProductionStatus=1) 
ORDER BY pva_server.DisplaySequence, pva_server.ServerName 

SELECT serviceID, service, ServiceName, LatestPeriod From Service WHERE (LatestPeriod IS NOT NULL) ORDER BY pvaDisplaySequence

/*num db by service*/
SELECT     service.serviceID, COUNT(orders.serviceID) AS NumDatabases
                      FROM       orders INNER JOIN 
                                 service ON orders.serviceID = service.serviceID INNER JOIN 
                                 receives INNER JOIN 
                                 pva_production ON receives.orderID = pva_production.OrderId ON orders.orderID = pva_production.OrderId 
                      WHERE     (receives.statusID = 1) AND (receives.Period05 = 1) AND (service.serviceID = 7)
                      GROUP BY   service.serviceID


/*Total Databases by service and period*/
SELECT count(pva_production.OrderId) AS TotalDatabases
          FROM   pva_production INNER JOIN 
                 orders ON pva_production.OrderId = orders.orderID 
          WHERE (pva_production.ProductionTypeId=1) AND (orders.serviceID = 7) AND (pva_production.Period = '201506')

/*Completed Databases by service and period*/                                         
SELECT COUNT(pva_production.OrderId) AS NumDatabases 
          FROM   pva_production INNER JOIN 
                 orders ON pva_production.OrderId = orders.orderID 
          WHERE (pva_production.ProductionTypeId=1) AND (orders.serviceID = 7) AND (pva_production.Period = '201506')
                 AND (DatabaseStatus='C')

/*Total and completed Databases*/
SELECT count(pva_production.OrderId) AS TotalDatabases, 'x' as Exp1
          FROM   pva_production INNER JOIN 
                 orders ON pva_production.OrderId = orders.orderID 
          WHERE (pva_production.ProductionTypeId=1) AND (orders.serviceID = 7) AND (pva_production.Period = '201506')
union
SELECT COUNT(pva_production.OrderId) AS NumDatabases ,'y' as Exp1
          FROM   pva_production INNER JOIN 
                 orders ON pva_production.OrderId = orders.orderID 
          WHERE (pva_production.ProductionTypeId=1) AND (orders.serviceID = 7) AND (pva_production.Period = '201506')
                 AND (DatabaseStatus='C')

select
	firstQuery.TotalDatabases,
	secondQuery.CompletedDatabases
from
(
	SELECT count(pva_production.OrderId) AS TotalDatabases, pva_production.ProductionTypeId
          FROM   pva_production INNER JOIN 
                 orders ON pva_production.OrderId = orders.orderID 
          WHERE (pva_production.ProductionTypeId=1) AND (orders.serviceID = 17) AND (pva_production.Period = '201506')
		  GROUP BY pva_production.ProductionTypeId
) as firstQuery
inner join
(
SELECT COUNT(pva_production.OrderId) AS CompletedDatabases, pva_production.ProductionTypeId
          FROM   pva_production INNER JOIN 
                 orders ON pva_production.OrderId = orders.orderID 
          WHERE (pva_production.ProductionTypeId=1) AND (orders.serviceID = 17) AND (pva_production.Period = '201506')
                 AND (DatabaseStatus='C')
		  GROUP BY pva_production.ProductionTypeId
) as secondQuery
on firstQuery.ProductionTypeId = secondQuery.ProductionTypeId

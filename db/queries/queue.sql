  /****** Queue for datatable  ******/
  SELECT service, OrderNumber, Priority, IsecJobStatus, BuildStatus, DownloadStatus
                        FROM pva_production
                        INNER JOIN orders
                        ON pva_production.OrderId = orders.orderID
						INNER JOIN service
						ON orders.serviceID = service.serviceID
                        WHERE Period = '201508'
                        AND (IsecJobStatus = 'W' OR BuildStatus = 'W' OR DownloadStatus = 'W')
                        ORDER BY Priority
						/* Optional: AND orders.serviceID = 7 */

  /*Databases in queue*/
  SELECT OrderNumber, Priority, IsecJobStatus, BuildStatus, DownloadStatus
  FROM pva_production
  INNER JOIN orders
  ON pva_production.OrderId = orders.orderID
  WHERE orders.serviceID = 7 AND Period = '201507'
  AND (IsecJobStatus = 'W' OR BuildStatus = 'W' OR DownloadStatus = 'W')

  /*Databases being produced*/
  SELECT OrderNumber, ServerName, IsecJobStatus, BuildStatus, DownloadStatus, *
  FROM pva_production
  INNER JOIN orders
  ON pva_production.OrderId = orders.orderID
  WHERE orders.serviceID = 7 AND Period = '201507'
  AND (IsecJobStatus = 'R' OR BuildStatus = 'R' OR DownloadStatus = 'R')
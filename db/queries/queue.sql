/****** Script for SelectTopNRows command from SSMS  ******/
SELECT [PvaProdId]
      ,[ProductionTypeId]
      ,[OrderId]
      ,[OrderNumber]
      ,[Period]
      ,[DataPeriod]
      ,[NumPeriods]
      ,[Cleared]
      ,[Priority]
      ,[BuildMode]
      ,[PanelTypeId]
      ,[BuildTypeId]
      ,[IsecJobPriority]
      ,[IsecJobNumber]
      ,[IsecJobStatus]
      ,[IsecJobTimeSubmit]
      ,[IsecJobTimeStart]
      ,[IsecJobSeconds]
      ,[DownloadStatus]
      ,[DownloadSeconds]
      ,[DownloadTimeStart]
      ,[ServerId]
      ,[BuildStatus]
      ,[BuildTimeStart]
      ,[BuildSeconds]
      ,[FactorySeconds]
      ,[ZipSeconds]
      ,[StatusDescription]
      ,[DatabaseStatus]
      ,[DatabaseDate]
      ,[PrepDate]
      ,[ClearedDate]
      ,[AutoBuild]
      ,[PvCopy]
      ,[ServerName]
      ,[GlbDate]
      ,[QueueFlag]
  FROM [PowerView].[powerview].[pva_production]


  /*Databases in queue*/
  SELECT OrderNumber, Priority, IsecJobStatus, BuildStatus, DownloadStatus
  FROM pva_production
  INNER JOIN orders
  ON pva_production.OrderId = orders.orderID
  WHERE orders.serviceID = 7 AND Period = '201507'
  AND (IsecJobStatus = 'W' OR BuildStatus = 'W' OR DownloadStatus = 'W')

  /*Databases being produced*/
  SELECT OrderNumber, ServerName, IsecJobStatus, BuildStatus, DownloadStatus
  FROM pva_production
  INNER JOIN orders
  ON pva_production.OrderId = orders.orderID
  WHERE orders.serviceID = 7 AND Period = '201507'
  AND (IsecJobStatus = 'R' OR BuildStatus = 'R' OR DownloadStatus = 'R')
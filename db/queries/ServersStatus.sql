/****** Script for SelectTopNRows command from SSMS  ******/
SELECT TOP 1000 [ServerId]
      ,[ServerName]
      ,[LocalPath]
      ,[pvaModeId]
      ,[pvaStatusId]
      ,[PvaProdId]
      ,[LastTimeCheck]
      ,[NextPvDemon]
      ,[NextPvJobSub]
      ,[NextPvDownload]
      ,[StatusDesc]
      ,[LocalPwFolder]
      ,[LocalPvaHome]
      ,[ProductionStatus]
      ,[DisplaySequence]
      ,[Nickname]
      ,[Terminate]
      ,[LaunchTime]
  FROM [PowerView].[powerview].[pva_server]
  order by ServerName

  /*Admin server status*/
  select ServerName,pvaModeId,pvaStatusID,ProductionStatus
  from [PowerView].[powerview].[pva_server]
  where pvaModeId=1 and pvaStatusID = 2

  /*Active servers*/
  select ServerName,pvaModeId,pvaStatusID,ProductionStatus
  from [PowerView].[powerview].[pva_server]
  where pvaModeId=2 and pvaStatusID = 2

  /*Number of active servers*/
  select Count (*)
  from [PowerView].[powerview].[pva_server]
  where pvaModeId=2 and pvaStatusID = 2

  /*Standby servers*/
  select ServerName,pvaModeId,pvaStatusID,ProductionStatus
  from [PowerView].[powerview].[pva_server]
  where pvaModeId=2 and pvaStatusID = 3

  /*Number of standby servers*/
  select Count (*)
  from [PowerView].[powerview].[pva_server]
  where pvaModeId=2 and pvaStatusID = 3

  /*Inactive servers*/
  select ServerName,pvaModeId,pvaStatusID,ProductionStatus
  from [PowerView].[powerview].[pva_server]
  where pvaModeId=0 and pvaStatusID = 0 and ProductionStatus = 1

  /*Number of inactive servers*/
  select Count (*)
  from [PowerView].[powerview].[pva_server]
  where pvaModeId=0 and pvaStatusID = 0 and ProductionStatus = 1
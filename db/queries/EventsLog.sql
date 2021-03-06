/****** Script for SelectTopNRows command from SSMS  ******/
SELECT [pvaEventId]
      ,[pvaProdId]
      ,[OrderId]
      ,[DateStamp]
      ,[Severity]
      ,[Summary]
      ,[Detail]
      ,[Status]
      ,[CallingProgram]
      ,[ClearedBy]
      ,[ClearedWhen]
      ,[ServerId]
      ,[ServerName]
  FROM [PowerView].[powerview].[pva_eventlog]
  where DateStamp > '2015-05-25'

  SELECT severity,count([Severity])
  FROM [PowerView].[powerview].[pva_eventlog]
  where DateStamp > '2015-05-28'
  group by Severity

 /* Nr of Critical events last 4 weeks*/
  select severity,count([Severity])
  FROM [PowerView].[powerview].[pva_eventlog]
  where DateStamp > DATEADD(d, -28, GETDATE()) and severity = 16
  group by Severity

  /* Nr of Warning events last 4 weeks*/
  select severity,count([Severity])
  FROM [PowerView].[powerview].[pva_eventlog]
  where DateStamp > DATEADD(d, -28, GETDATE()) and severity = 48
  group by Severity

  /* Nr of Information events last 4 weeks*/
  select severity,count([Severity])
  FROM [PowerView].[powerview].[pva_eventlog]
  where DateStamp > DATEADD(d, -28, GETDATE()) and severity = 64
  group by Severity

  /* Nr total of events last 4 weeks*/
  select count(*) FROM [PowerView].[powerview].[pva_eventlog]
  where DateStamp > DATEADD(d, -28, GETDATE())
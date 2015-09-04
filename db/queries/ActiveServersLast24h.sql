/*Active servers last 24 hours by BuildTimeStart*/
select Count(DISTINCT ServerName), dateadd(HH, datediff(HH,0, BuildTimeStart), 0) As Hour
from pva_production
where period = 201508 and BuildTimeStart > dateadd(HH, -24, getdate())
group by dateadd(HH, datediff(HH,0, BuildTimeStart), 0)
order by dateadd(HH, datediff(HH,0, BuildTimeStart), 0)


/*Active servers last 24 hours by BuildTimeStart and BuildTimeStart+BuildSeconds*/
select count(DISTINCT t.ServerName), t.Hour
from (select ServerName, dateadd(HH, datediff(HH,0, BuildTimeStart), 0) As Hour
from pva_production
where period = 201508 and BuildTimeStart > dateadd(HH, -24, getdate())
union all
select ServerName, dateadd(HH, datediff(HH, 0, dateadd(ss, BuildSeconds, BuildTimeStart)), 0) as Hour
from pva_production
where period = 201508 and BuildTimeStart > dateadd(HH, -24, getdate())) t
Group By t.Hour


/*Test*/
select Count(DISTINCT ServerName), dateadd(HH, datediff(HH, 0, dateadd(ss, BuildSeconds, BuildTimeStart)), 0) as Hour
from pva_production
where period = 201508 and BuildTimeStart > dateadd(HH, -24, getdate())
group by dateadd(HH, datediff(HH, 0, dateadd(ss, BuildSeconds, BuildTimeStart)), 0)
order by dateadd(HH, datediff(HH, 0, dateadd(ss, BuildSeconds, BuildTimeStart)), 0)


/*Test*/
select Count(DISTINCT ServerName), dateadd(HH, datediff(HH, 0, dateadd(ss, BuildSeconds, BuildTimeStart)), 0) as Hour
from pva_production
where period = 201508 and BuildTimeStart >= dateadd(HH, -24, getdate())
group by dateadd(HH, datediff(HH, 0, dateadd(ss, BuildSeconds, BuildTimeStart)), 0)
order by dateadd(HH, datediff(HH, 0, dateadd(ss, BuildSeconds, BuildTimeStart)), 0)

/*Test*/
select count(DISTINCT(ServerName)), 
		BuildTimeStart, 
		BuildSeconds, 
		dateadd(ss, BuildSeconds, BuildTimeStart) As BuildPlusSeconds, 
		datediff(HH, 0, dateadd(ss, BuildSeconds, BuildTimeStart)) As BuildPlusSecondsTrans, 
		dateadd(HH, datediff(HH, 0, dateadd(ss, BuildSeconds, BuildTimeStart)), 0) As BuildPlusSecondsHours, 
		dateadd(HH, -24, getdate()) As NowLess24h
from pva_production
where period = 201508 and BuildTimeStart >= dateadd(HH, -30, getdate())
group by BuildTimeStart, BuildSeconds
order by dateadd(HH, datediff(HH, 0, dateadd(ss, BuildSeconds, BuildTimeStart)), 0)








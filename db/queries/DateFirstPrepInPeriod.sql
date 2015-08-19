	select MIN(PrepDate) 
	FROM   pva_production INNER JOIN 
           orders ON pva_production.OrderId = orders.orderID 
    WHERE  (pva_production.ProductionTypeId=1) AND (orders.serviceID = 7) AND (pva_production.Period = 201507) AND (pva_production.DatabaseDate < '2015-07-25' or pva_production.DatabaseDate = NULL)

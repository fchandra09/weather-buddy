INSERT INTO User (First_Name, Last_Name, Email, `Password`, Created_On, Modified_On)
SELECT First_Name, Last_Name, Email, `Password`, NOW() AS Created_On, NOW() AS Modified_On
FROM (
	SELECT 'Felicia' AS First_Name, 'Chandra' AS Last_Name, 'fchandr2@illinois.edu' AS Email, '$2y$10$QMd5nB54dJWaAeb4dCk3D.hZJXPk9otlR1xtyqoioACF7lHR4vcBa' AS `Password`
    UNION SELECT 'Margie', 'Chubin', 'chubin2@illinois.edu', '$2y$10$QMd5nB54dJWaAeb4dCk3D.hZJXPk9otlR1xtyqoioACF7lHR4vcBa'
    UNION SELECT 'Aakanksha', 'Ardhapurkar', 'ardhapu2@illinois.edu', '$2y$10$QMd5nB54dJWaAeb4dCk3D.hZJXPk9otlR1xtyqoioACF7lHR4vcBa'
    UNION SELECT 'Jinge', 'Li', 'jingeli2@illinois.edu', '$2y$10$QMd5nB54dJWaAeb4dCk3D.hZJXPk9otlR1xtyqoioACF7lHR4vcBa'
    UNION SELECT 'Menglin', 'Tian', 'mtian6@illinois.edu', '$2y$10$QMd5nB54dJWaAeb4dCk3D.hZJXPk9otlR1xtyqoioACF7lHR4vcBa'
) Tmp
WHERE NOT EXISTS (
	SELECT U.ID
    FROM User U
    WHERE U.Email = Tmp.Email);

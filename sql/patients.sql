CREATE TABLE IF NOT EXISTS patients (
    id BIGSERIAL PRIMARY KEY,        
    name VARCHAR(100) NOT NULL,       
    cpf CHAR(11) NOT NULL,           
    birth_date DATE NOT NULL,         
    phone CHAR(10),                   
    cellphone CHAR(11),               
    email VARCHAR(100)                
);

CREATE INDEX IF NOT EXISTS idx_patients_status ON patients (status);

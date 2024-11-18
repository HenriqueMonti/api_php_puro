# FERRAMENTAS USADAS:
- MariaDB
- HeidiSQL
- Postman
- Visual Studio Code
- PHP 8.3.13 (Laravel Herd)

# CRIAÇÃO DO BANCO:
```SQL
CREATE DATABASE dbTeste;
USE dbTeste;

CREATE TABLE especialidade (
  id int NOT NULL AUTO_INCREMENT,
  name varchar(50) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

CREATE TABLE medico (
  id int NOT NULL AUTO_INCREMENT,
  nome varchar(75) NOT NULL,
  crm int NOT NULL,
  especialidadeId int DEFAULT NULL,
  PRIMARY KEY (id),
  KEY especialidadeId (especialidadeId),
  CONSTRAINT medico_ibfk_1 FOREIGN KEY (especialidadeId) REFERENCES especialidade (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE paciente (
  id int NOT NULL AUTO_INCREMENT,
  nome varchar(75) NOT NULL,
  endereco varchar(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=UTF8MB4;

CREATE TABLE agendamentos (
  id int NOT NULL AUTO_INCREMENT,
  medicoId int NOT NULL,
  pacienteId int NOT NULL,
  dataConsulta datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY medicoId (medicoId),
  KEY pacienteId (pacienteId),
  CONSTRAINT agendamentos_ibfk_1 FOREIGN KEY (medicoId) REFERENCES medico (id),
  CONSTRAINT agendamentos_ibfk_2 FOREIGN KEY (pacienteId) REFERENCES paciente (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

# EXECUÇÃO:
php -S localhost:8000

# TESTES (Postman):
GET localhost:8000/api/pacientes

# ROTAS:
Rotas GET
    /api/pacientes -> Funcionando OK
    /api/pacientes/{id} -> Funcionando OK
    /api/medicos -> Funcionando OK
    /api/medicos/especialidade -> Funcionando OK? Não há maneira de criar uma especialidade, porém retorna 200
    /api/medicos/especialidade/{id} -> Funcionando OK? Não há maneira de criar uma especialidade, porém retorna 200
    /api/consultas -> Retorna 200, porém não há maneira de criar uma consulta visto que não é possivel criar especialidade para médicos

Rotas POST
    /api/pacientes -> Funcionando OK. Forma de POST: {"nome": "varchar","endereco": "varchar"} -> Retorna 200 "Paciente criado"
    /api/medicos -> Funcionando, porém não há maneira de realizar o POST de uma especialidade? Forma de POST: {"nome": "varchar","crm": "int","especialidadeId": "int FK especialidade"} Ao não informar especialidade no JSON, retorna "É preciso informar a especialidade do médico"
    /api/consultas -> Impossível testar, visto que precisa de um médico. Forma de POST: {"medicoId": "int", "pacienteId": "int", "dataConsulta": "datetime"}

Rotas PUT
    /api/pacientes/{id} -> Funcionando OK. Forma de PUT: {"nome": "varchar","endereco": "varchar"} -> Retorna 200 "Paciente atualizado"
    /api/medicos/{id} -> Funcionando, porém não há maneira de realizar o POST de uma especialidade? Forma de PUT: {"nome": "varchar","crm": "int","especialidadeId": "int FK especialidade"}. Ao não informar especialidade no JSON, retorna "É preciso informar a especialidade do médico"
    /api/consultas/{id} -> Impossível testar, visto que precisa de um médico. Forma de PUT:{"medicoId": "int", "pacienteId": "int", "dataConsulta": "datetime"}

Rotas DELETE
    /api/pacientes/{id} -> Funcionando OK. Retorna 200 "Paciente excluído"
    /api/medicos/{id} -> Funcionando OK. Retorna 200 "Médico excluído"
    /api/consultas/{id} -> Impossível testar

# CASO DE USO:

- Estamos trabalhando com uma clinica ficticia, chamada clinica sol
- esta clinica trabalha com as especialidades medicas de cardiolosta, oftalmologista, clinico geral e pediatra (favor registrar todas no banco de dados)
- ela funciona das 7 da manha ate as 18 horas da tarde
- cada consulta dura uma hora
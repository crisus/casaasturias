#!/bin/sh
#Inicializacion externa
sql_host="localhost"
slq_usuario="root"
sql_password="sekret"
sql_database="programador"

sql_user="reservas"
sql_p="sekret"

# Creamos el nuevo usuario sql
mysql -u ${slq_usuario} -p${sql_password} -e "CREATE USER '${sql_user}'@'localhost' IDENTIFIED BY '${sql_p}'; GRANT USAGE ON * . * TO '${sql_user}'@'localhost' IDENTIFIED BY '${sql_p}';"

# Comprobamos errores
if [ $? == 0 ]; then
        echo " El usuario ${sql_user} se ha creado con éxito."

        # Creamos la nueva base de datos
        mysql -u ${sql_usuario} -p${sql_password} -e "CREATE DATABASE IF NOT EXISTS ${sql_database} DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci; GRANT ALL PRIVILEGES ON ${sql_database} . * TO '${sql_user}'@'localhost';"

	file= "./COPIA.sql"
	# Comprobamos errores
        if [ $? == 0 ]; then
                echo " La base de datos ${sql_database} se ha creado con éxito."
                echo " El usuario ${sql_reservas} tiene permisos sobre la base de datos ${sql_database}."

		mysql -u${sql_user} -p{$sql_p} ${sql_database} --default-character-set=utf8 -r ${file}
	else
		echo "Error al cargar copia de seguridad ${file}."
        fi
fi

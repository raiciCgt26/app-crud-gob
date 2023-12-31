export class Model {
  /**
   * Ejecuta una query con base a un string, si vas a hacer un
   * INSERT o UPDATE, especifica los parametros tableName y primaryKey
   * @param {*} query
   * @param {*} tableName
   * @param {*} primaryKey
   * @returns
   */
  //
  //   async execQuery(query, tableName = "", primaryKey = "") {
  //     const data = {
  //       query,
  //     };

  //     if (tableName != "") data.table_name = tableName;
  //     if (primaryKey != "") data.primary_key = primaryKey;

  //     let result = await fetch("../php/exec.php", {
  //       method: "POST",
  //       body: JSON.stringify(data),
  //     }).then((data) => data.json());

  //     console.log(result);

  //     return result;
  //   }
  // }

  async execQuery(url, data = {}) {
    try {
      const response = await fetch(url, {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
          "Content-Type": "application/json",
        },
      });

      const result = await response.json();
      return result;
    } catch (error) {
      console.error("Error:", error);
      return { success: false, message: "Error en la solicitud" };
    }
  }
}

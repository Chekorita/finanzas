package Clases;

public class Tipo_gasto {
	private int id;
	private String nombre;
	private int tipo;
	private int requiere_persona;
	private int id_usuario;

	public Tipo_gasto() {}
	
	
	public Tipo_gasto(int id, String nombre, int tipo, int requiere_persona, int id_usuario) {
		this.id = id;
		this.nombre = nombre;
		this.tipo = tipo;
		this.requiere_persona = requiere_persona;
		this.id_usuario = id_usuario;
	}


	public int getId() {
		return id;
	}
	public void setId(int id) {
		this.id = id;
	}
	public String getNombre() {
		return nombre;
	}
	public void setNombre(String nombre) {
		this.nombre = nombre;
	}
	public int getTipo() {
		return tipo;
	}
	public void setTipo(int tipo) {
		this.tipo = tipo;
	}
	public int getRequiere_persona() {
		return requiere_persona;
	}
	public void setRequiere_persona(int requiere_persona) {
		this.requiere_persona = requiere_persona;
	}
	public int getId_usuario() {
		return id_usuario;
	}
	public void setId_usuario(int id_usuario) {
		this.id_usuario = id_usuario;
	}
}

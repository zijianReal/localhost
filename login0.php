<form action="login.php" method="post">
		<fieldset>
			<legend>用户登录</legend>
			<ul>
				<li>
					<label>用户名:</label>
					<input type="text" name="username">
				</li>
				<li>
					<label>密   码:</label>
					<input type="password" name="password">
				</li>
				<li>
					<label> </label>
					<input type="checkbox" name="remember" value="yes">7天内自动登录
				</li>
				<li>
					<label> </label>
                    <td colspan="2" >
					<input type="submit" name="login" value="登录">
                    <input type="reset" name="reset" value="重置">
                    <input type="button" name="register" value="注册" onclick="location.href='register0.php'">
                    </td>
                </li>
			</ul>
		</fieldset>
	</form>